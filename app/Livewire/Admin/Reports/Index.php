<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Invoice;
use Livewire\Component;
use Illuminate\Support\Facades\Response;

class Index extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        // Default to current year
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate = now()->endOfYear()->format('Y-m-d');
    }

    public function exportTaxSummary()
    {
        $businessId = auth()->user()->current_business_id;

        $invoices = Invoice::where('business_id', $businessId)
            ->where('type', 'invoice')
            ->where('status', 'paid')
            ->whereBetween('invoice_date', [$this->startDate, $this->endDate])
            ->orderBy('invoice_date', 'asc')
            ->get();

        $csvData = [];
        $csvData[] = ['Invoice Number', 'Client Name', 'Date', 'Subtotal', 'Tax Collected', 'Total Amount', 'Currency'];

        foreach ($invoices as $invoice) {
            $csvData[] = [
                $invoice->invoice_number,
                $invoice->client->name ?? 'N/A',
                $invoice->invoice_date->format('Y-m-d'),
                $invoice->subtotal,
                $invoice->tax_total,
                $invoice->grand_total,
                $invoice->currency ?? 'USD'
            ];
        }

        $filename = "tax_summary_{$this->startDate}_to_{$this->endDate}.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $businessId = auth()->user()->current_business_id;

        $query = Invoice::where('business_id', $businessId)
            ->where('type', 'invoice')
            ->whereBetween('invoice_date', [$this->startDate, $this->endDate]);

        // Calculate totals based on the date range
        $totalRevenue = (clone $query)->where('status', 'paid')->sum('amount_paid');
        $outstandingBalance = (clone $query)->whereIn('status', ['sent', 'overdue'])->sum('amount_due');
        $totalTaxCollected = (clone $query)->where('status', 'paid')->sum('tax_total');

        // Recent paid invoices for the preview table
        $recentPaidInvoices = (clone $query)->where('status', 'paid')
            ->orderBy('invoice_date', 'desc')
            ->take(10)
            ->get();

        return view('livewire.admin.reports.index', [
            'totalRevenue' => $totalRevenue,
            'outstandingBalance' => $outstandingBalance,
            'totalTaxCollected' => $totalTaxCollected,
            'recentPaidInvoices' => $recentPaidInvoices,
        ]);
    }
}
