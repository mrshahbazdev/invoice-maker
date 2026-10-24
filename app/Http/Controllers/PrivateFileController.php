<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Template;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Serves NEW private-disk uploads behind authentication + ownership checks.
 *
 * Private uploads are stored on the 'local' disk under a 'private/' prefix
 * (storage/app/private/...), which is NOT reachable through the public/storage
 * symlink. The stored DB path (e.g. 'private/receipts/<hash>.png') is looked
 * up in the owning table first, so a request is authorised against the real
 * owner record -- never against a caller-supplied path alone.
 *
 * Existing public-disk uploads (paths without the 'private/' prefix, e.g.
 * 'receipts/<hash>.png') are intentionally NOT served here; they keep working
 * through their existing public URLs unchanged.
 *
 * Safe serving: only images and PDFs are served inline; every other allowed
 * type is forced as an attachment, the Content-Type comes from the file's
 * detected mime (never from a caller-supplied value), and nosniff is set so
 * a browser never sniffs a served file as HTML/script.
 */
class PrivateFileController
{
    /** Kind => [model lookup, private directory] */
    protected const KINDS = [
        'receipts' => 'private/receipts',
        'signatures' => 'private/signatures',
        'tickets' => 'private/tickets',
    ];

    /** Mime types that may be displayed inline in the browser. */
    protected const INLINE_MIMES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'application/pdf',
    ];

    public function show(Request $request, string $kind, string $file)
    {
        // Defence in depth: the route is also behind the 'auth' middleware,
        // so reaching this point unauthenticated must still be rejected.
        if (!Auth::check()) {
            abort(403);
        }

        if (!array_key_exists($kind, self::KINDS)) {
            abort(404);
        }

        // The route constraint already excludes slashes; reject any
        // traversal attempt outright instead of normalising it away.
        if ($file === '' || $file !== basename($file) || str_contains($file, '..')) {
            abort(404);
        }

        $path = self::KINDS[$kind] . '/' . $file;
        $user = Auth::user();

        if ($kind === 'receipts') {
            $expense = Expense::where('receipt_path', $path)->first();
            if (!$expense) {
                abort(404);
            }
            if (!$user->is_super_admin && $expense->business_id !== $user->business_id) {
                abort(403);
            }
        } elseif ($kind === 'signatures') {
            $template = Template::where('signature_path', $path)->first();
            if (!$template) {
                abort(404);
            }
            if (!$user->is_super_admin && $template->business_id !== $user->business_id) {
                abort(403);
            }
        } else {
            $reply = TicketReply::where('attachment_path', $path)->with('ticket')->first();
            if (!$reply || !$reply->ticket) {
                abort(404);
            }
            // Ticket attachments: the ticket owner, or a super-admin
            // (the existing admin support pattern), and nobody else.
            if (!$user->is_super_admin && $reply->ticket->user_id !== $user->id) {
                abort(403);
            }
        }

        $disk = Storage::disk('local');
        if (!$disk->exists($path)) {
            abort(404);
        }

        $mime = $disk->mimeType($path) ?: 'application/octet-stream';
        $inline = in_array($mime, self::INLINE_MIMES, true);
        $disposition = ($inline ? 'inline' : 'attachment') . '; filename="' . $file . '"';

        return response()->stream(function () use ($disk, $path) {
            $stream = $disk->readStream($path);
            if ($stream) {
                fpassthru($stream);
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => $disposition,
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }
}
