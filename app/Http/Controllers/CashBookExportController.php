<?php

namespace App\Http\Controllers;

use App\Models\CashBookEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CashBookExportController
{
    public function exportExcel(Request $request)
    {
        $business = Auth::user()->business;
        $query = CashBookEntry::with(['category', 'invoice', 'expense'])
            ->where('business_id', $business->id);

        if ($request->has('startDate')) {
            $query->whereDate('date', '>=', $request->startDate);
        }
        if ($request->has('endDate')) {
            $query->whereDate('date', '<=', $request->endDate);
        }

        $entries = $query->orderBy('date', 'asc')
            ->orderBy('booking_number', 'asc')
            ->get();

        $fileName = 'CashBook_' . str_replace(' ', '_', $business->name) . '_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        return new StreamedResponse(function () use ($entries) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
            fwrite($handle, "sep=,\n"); // Tell Excel the separator is comma

            fputcsv($handle, [
                __('Booking Number'),
                __('Date'),
                __('Type'),
                __('Source'),
                __('Category'),
                __('Description'),
                __('Amount'),
                __('Linked Job'),
                __('Posting Rule')
            ]);

            foreach ($entries as $entry) {
                fputcsv($handle, [
                    $entry->booking_number,
                    $entry->date->format('d.m.Y'),
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

    public function exportCsv(Request $request)
    {
        $business = Auth::user()->business;
        $query = CashBookEntry::with(['category', 'invoice', 'expense'])
            ->where('business_id', $business->id);

        if ($request->has('startDate')) {
            $query->whereDate('date', '>=', $request->startDate);
        }
        if ($request->has('endDate')) {
            $query->whereDate('date', '<=', $request->endDate);
        }

        $entries = $query->orderBy('date', 'asc')
            ->orderBy('booking_number', 'asc')
            ->get();

        $fileName = 'CashBook_' . $business->name . '_' . ($request->startDate ?? 'all') . '_to_' . ($request->endDate ?? now()->format('Y-m-d')) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        return new StreamedResponse(function () use ($entries) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM for Excel UTF-8 support

            fputcsv($handle, [
                __('Booking Number'),
                __('Date'),
                __('Type'),
                __('Source'),
                __('Category'),
                __('Description'),
                __('Amount'),
                __('Linked Job'),
                __('Posting Rule')
            ]);

            foreach ($entries as $entry) {
                fputcsv($handle, [
                    $entry->booking_number,
                    $entry->date->format('d.m.Y'),
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

    public function exportPdf(Request $request)
    {
        $business = Auth::user()->business;
        $query = CashBookEntry::with(['category', 'invoice', 'expense'])
            ->where('business_id', $business->id);

        if ($request->has('startDate')) {
            $query->whereDate('date', '>=', $request->startDate);
        }
        if ($request->has('endDate')) {
            $query->whereDate('date', '<=', $request->endDate);
        }

        $entries = $query->orderBy('date', 'asc')
            ->orderBy('booking_number', 'asc')
            ->get();

        $incomeTotal = $entries->where('type', 'income')->sum('amount');
        $expenseTotal = $entries->where('type', 'expense')->sum('amount');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.cash-book', [
            'business' => $business,
            'entries' => $entries,
            'incomeTotal' => $incomeTotal,
            'expenseTotal' => $expenseTotal,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('CashBook_' . $business->name . '_' . now()->format('Y-m-d') . '.pdf');
    }
}
