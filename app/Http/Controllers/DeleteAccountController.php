<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Public account-deletion request page.
 *
 * This is the "Delete account URL" required by the Google Play
 * Data safety form: a user who cannot (or does not want to) delete
 * their account from inside the app can request deletion here.
 * The request is recorded as a support ticket for the account owner
 * and emailed to the super-admins, so it cannot be lost. The
 * response is intentionally identical whether or not the email
 * address belongs to an account, so the page never reveals
 * whether an address is registered.
 */
class DeleteAccountController
{
    public function show()
    {
        return view('delete-account');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'confirm' => 'accepted',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user) {
            $ticket = Ticket::create([
                'user_id' => $user->id,
                'subject' => 'Account deletion request',
                'status' => 'open',
                'priority' => 'high',
                'category' => 'account',
            ]);

            TicketReply::create([
                'ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'message' => 'The account owner requested deletion of this account and its associated data via the public delete-account page. Legal retention duties (for example tax records) may require keeping invoice data for a defined period even after deletion.',
            ]);

            $adminEmails = User::where('is_super_admin', true)
                ->whereNotNull('email')
                ->pluck('email')
                ->filter()
                ->all();

            if ($adminEmails) {
                try {
                    Mail::raw(
                        "Account deletion request for {$validated['email']} (ticket #{$ticket->id}). Please process it in the admin area.",
                        function ($message) use ($adminEmails) {
                            $message->to($adminEmails)
                                ->subject('Account deletion request');
                        }
                    );
                } catch (\Throwable $e) {
                    // The ticket is the durable record; a mail failure
                    // must not turn a valid request into an error page.
                    Log::warning('Delete-account notification email failed', [
                        'ticket_id' => $ticket->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        return view('delete-account', ['submitted' => true]);
    }
}
