<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceComment;
use App\Services\PdfGenerationService;
use Illuminate\Support\Facades\DB;

class PublicInvoiceController
{
    public function show(Request $request, Invoice $invoice)
    {
        $hasValidSignature = $request->hasValidSignature();

        \Log::info('PublicInvoiceController@show access', [
            'id' => $invoice->id,
            'url' => $request->fullUrl(),
            'hasValidSignature' => $hasValidSignature,
            'user' => auth()->id(),
            'app_url' => config('app.url'),
            'scheme' => $request->getScheme(),
            'host' => $request->getHost(),
        ]);

        if (!$hasValidSignature) {
            // Log exactly why it might be failing (optional, for very deep debug)
            return response()->view('errors.403', [
                'exception' => new \Exception('The link has an invalid or expired signature. Please ensure you are using the exact link provided.')
            ], 403);
        }

        $invoice->load(['client', 'business', 'items.product', 'payments']);

        // Set locale based on preference
        $locale = $invoice->client->language
            ?? $invoice->business->user->language
            ?? config('app.locale');
        \Illuminate\Support\Facades\App::setLocale($locale);

        return view('invoices.public', compact('invoice'));
    }

    public function download(Request $request, Invoice $invoice, PdfGenerationService $pdfService)
    {
        if (!$request->hasValidSignature()) {
            return response('Invalid or expired invoice link.', 403);
        }

        // Set locale based on preference
        $locale = $invoice->client->language
            ?? $invoice->business->user->language
            ?? config('app.locale');
        \Illuminate\Support\Facades\App::setLocale($locale);

        return $pdfService->download($invoice);
    }

    public function approve(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature()) {
            return response('Unauthorized signature.', 403);
        }

        if (!$invoice->isEstimate()) {
            abort(404);
        }

        $invoice->update(['status' => 'sent']); // Or a specific 'approved' status if needed

        return redirect()->back()->with('success', 'Estimate approved successfully.');
    }

    public function requestRevision(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature()) {
            return response('Unauthorized signature.', 403);
        }

        if (!$invoice->isEstimate()) {
            abort(404);
        }

        $invoice->update(['status' => 'draft']); // Back to draft for revision

        return redirect()->back()->with('success', 'Revision requested. The business owner will be notified.');
    }

    public function addComment(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature() && !auth()->check()) {
            return response('Unauthorized.', 403);
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        InvoiceComment::create([
            'invoice_id' => $invoice->id,
            'user_id' => auth()->id() ?? $invoice->client->user_id, // Fallback if guest but signed
            'comment' => $request->comment,
            'is_internal' => false,
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }
}
