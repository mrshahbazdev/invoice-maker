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
        die('Hitting Controller. User: ' . (auth()->check() ? auth()->id() : 'Guest'));
        \Log::info('PublicInvoiceController@show', [
            'url' => $request->fullUrl(),
            'hasValidSignature' => $request->hasValidSignature(),
            'user' => auth()->id(),
        ]);

        if (!$request->hasValidSignature()) {
            return response('Invalid or expired invoice link. Signature verification failed.', 403);
        }

        $invoice->load(['client', 'business', 'items.product', 'payments']);

        // Set locale based on client preference
        if ($invoice->client && $invoice->client->language) {
            \App::setLocale($invoice->client->language);
        }

        return view('invoices.public', compact('invoice'));
    }

    public function download(Request $request, Invoice $invoice, PdfGenerationService $pdfService)
    {
        if (!$request->hasValidSignature()) {
            return response('Invalid or expired invoice link.', 403);
        }

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
