<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\PdfGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InvoiceController
{
    protected PdfGenerationService $pdfService;

    public function __construct(PdfGenerationService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function downloadPdf(Invoice $invoice)
    {
        Gate::authorize('view', $invoice);

        return $this->pdfService->download($invoice);
    }

    public function previewPdf(Invoice $invoice)
    {
        Gate::authorize('view', $invoice);

        $pdf = $this->pdfService->generate($invoice);

        return response($pdf)
            ->header('Content-Type', 'application/pdf');
    }
}
