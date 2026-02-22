<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Invoice;

class InvoiceNumberService
{
    public function generate(Business $business): string
    {
        $prefix = $business->invoice_number_prefix ?? 'INV';
        $next = $business->invoice_number_next ?? 1;

        $unique = false;
        $number = '';

        while (!$unique) {
            $number = sprintf('%s-%04d', $prefix, $next);

            // Check if this number already exists for this business
            $exists = Invoice::where('business_id', $business->id)
                ->where('invoice_number', $number)
                ->exists();

            if (!$exists) {
                $unique = true;
            } else {
                $next++;
            }
        }

        // Update the business's next number for future use
        $business->update(['invoice_number_next' => $next + 1]);

        return $number;
    }
}
