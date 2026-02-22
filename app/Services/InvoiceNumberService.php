<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Invoice;

class InvoiceNumberService
{
    public function generate(Business $business): string
    {
        $year = now()->year;
        $prefix = 'INV-' . $year;

        $lastInvoice = Invoice::where('business_id', $business->id)
            ->where('invoice_number', 'like', $prefix . '-%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = (int) str_replace($prefix . '-', '', $lastInvoice->invoice_number);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('%s-%04d', $prefix, $newNumber);
    }
}
