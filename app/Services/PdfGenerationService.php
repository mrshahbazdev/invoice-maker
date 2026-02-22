<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerationService
{
    public function generate(Invoice $invoice)
    {
        $invoice->load(['client', 'business', 'items.product', 'template']);

        // Set locale based on client preference
        if ($invoice->client && $invoice->client->language) {
            \App::setLocale($invoice->client->language);
        }

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
        ]);

        return $pdf->output();
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['client', 'business', 'items.product', 'template']);

        // Set locale based on client preference
        if ($invoice->client && $invoice->client->language) {
            \App::setLocale($invoice->client->language);
        }

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
        ]);

        return $pdf->download(($invoice->isEstimate() ? __('Estimate') : __('Invoice')) . '-' . $invoice->invoice_number . '.pdf');
    }
}
