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
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired invoice link.');
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
            abort(403, 'Invalid or expired invoice link.');
        }

        return $pdfService->download($invoice);
    }

    public function approve(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
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
            abort(403);
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
            abort(403);
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
