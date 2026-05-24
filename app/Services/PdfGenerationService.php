<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Invoice;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerationService
{
    public function generate(Invoice $invoice)
    {
        $invoice->load(['client', 'business.user', 'items.product', 'template']);

        // Set locale based on preference
        $locale = $invoice->client->language
            ?? $invoice->business->user->language
            ?? config('app.locale');
        \Illuminate\Support\Facades\App::setLocale($locale);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
        ]);

        return $pdf->output();
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['client', 'business', 'items.product', 'template']);

        // Set locale based on preference
        $locale = $invoice->client->language
            ?? $invoice->business->user->language
            ?? config('app.locale');
        \Illuminate\Support\Facades\App::setLocale($locale);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
        ]);

        return $pdf->download(($invoice->isEstimate() ? __('Estimate') : __('Invoice')) . '-' . $invoice->invoice_number . '.pdf');
    }

    public function generateStatement(Client $client, $invoices, Business $business, $totalInvoiced, $totalPaid, $totalOutstanding)
    {
        // Set locale based on preference
        $locale = $client->language
            ?? $business->user->language
            ?? config('app.locale');
        \Illuminate\Support\Facades\App::setLocale($locale);

        $pdf = Pdf::loadView('client-portal.statement-pdf', [
            'client' => $client,
            'business' => $business,
            'invoices' => $invoices,
            'totalInvoiced' => $totalInvoiced,
            'totalPaid' => $totalPaid,
            'totalOutstanding' => $totalOutstanding,
        ]);

        return $pdf->output();
    }
}
