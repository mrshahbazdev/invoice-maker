<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Services\PdfGenerationService;

class PublicInvoiceController
{
    public function show(Request $request, Invoice $invoice)
    {
        if (!$request->hasValidSignature()) {
            abort(401, 'Invalid or expired invoice link.');
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
            abort(401, 'Invalid or expired invoice link.');
        }

        return $pdfService->download($invoice);
    }
}
