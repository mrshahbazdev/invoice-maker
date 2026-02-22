<?php

namespace App\Http\Controllers;

use App\Models\CashBookEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CashBookExportController
{
    public function exportCsv(Request $request)
    {
        $business = Auth::user()->business;
        $entries = CashBookEntry::with(['category', 'invoice', 'expense'])
            ->where('business_id', $business->id)
            ->orderBy('date', 'asc')
            ->orderBy('booking_number', 'asc')
            ->get();

        $fileName = 'CashBook_' . $business->name . '_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return new StreamedResponse(function () use ($entries) {
            $handle = fopen('php://output', 'w');

            // Header row for Sweet Spot Pro compatibility
            fputcsv($handle, [
                'Booking Number',
                'Date',
                'Type',
                'Source',
                'Category',
                'Description',
                'Amount',
                'Linked Job',
                'Posting Rule'
            ]);

            foreach ($entries as $entry) {
                fputcsv($handle, [
                    $entry->booking_number,
                    $entry->date->format('Y-m-d'),
                    ucfirst($entry->type),
                    ucfirst($entry->source),
                    $entry->category ? $entry->category->name : 'N/A',
                    $entry->description,
                    $entry->amount,
                    $entry->invoice ? $entry->invoice->invoice_number : 'General',
                    $entry->category ? $entry->category->posting_rule : ''
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
