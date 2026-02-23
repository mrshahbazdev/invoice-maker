<?php

namespace App\Livewire\Reports;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Profitability extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $business = Auth::user()->business;

        // 1. Overall Net Income
        $totalRevenue = Invoice::where('business_id', $business->id)
            ->whereBetween('invoice_date', [$this->startDate, $this->endDate])
            ->where('status', 'paid')
            ->sum('grand_total');

        $totalExpenses = Expense::where('business_id', $business->id)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');

        $netIncome = $totalRevenue - $totalExpenses;

        // 2. Customer Profitability (Invoices vs Linked Expenses)
        $clientProfitability = Client::where('business_id', $business->id)
            ->with([
                'invoices' => function ($query) {
                    $query->whereBetween('invoice_date', [$this->startDate, $this->endDate])
                        ->where('status', 'paid');
                }
            ])
            ->get()
            ->map(function ($client) {
                $revenue = $client->invoices->sum('total');

                $invoiceIds = $client->invoices->pluck('id');
                $directCosts = Expense::whereIn('invoice_id', $invoiceIds)->sum('amount');

                return [
                    'name' => $client->company_name ?? $client->name,
                    'revenue' => $revenue,
                    'costs' => $directCosts,
                    'profit' => $revenue - $directCosts,
                    'margin' => $revenue > 0 ? (($revenue - $directCosts) / $revenue) * 100 : 0
                ];
            })
            ->filter(fn($c) => $c['revenue'] > 0 || $c['costs'] > 0)
            ->sortByDesc('profit');

        // 3. Product Profitability (Price vs Purchase Price)
        $productProfitability = DB::table('invoice_items')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->join('products', 'invoice_items.product_id', '=', 'products.id')
            ->where('invoices.business_id', $business->id)
            ->where('invoices.status', 'paid')
            ->whereBetween('invoices.invoice_date', [$this->startDate, $this->endDate])
            ->select(
                'products.name',
                DB::raw('SUM(invoice_items.quantity) as total_sold'),
                DB::raw('SUM(invoice_items.total) as total_revenue'),
                DB::raw('SUM(invoice_items.quantity * products.purchase_price) as total_cost')
            )
            ->groupBy('products.id', 'products.name')
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'sold' => $product->total_sold,
                    'revenue' => $product->total_revenue,
                    'costs' => $product->total_cost,
                    'profit' => $product->total_revenue - $product->total_cost,
                    'margin' => $product->total_revenue > 0 ? (($product->total_revenue - $product->total_cost) / $product->total_revenue) * 100 : 0
                ];
            })
            ->sortByDesc('profit');

        return view('livewire.reports.profitability', [
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
            'netIncome' => $netIncome,
            'clientProfitability' => $clientProfitability,
            'productProfitability' => $productProfitability,
        ]);
    }
}
