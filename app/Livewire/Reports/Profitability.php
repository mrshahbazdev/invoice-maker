<?php

namespace App\Livewire\Reports;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Payment;
use App\Models\CashBookEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Profitability extends Component
{
    use WithPagination;

    public $search = '';
    public $period = 'this_month';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->setPeriod('this_month');
    }

    public function setPeriod($preset)
    {
        $this->period = $preset;

        switch ($preset) {
            case 'this_month':
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = now()->subMonthNoOverflow()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->subMonthNoOverflow()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_3_months':
                $this->startDate = now()->subMonthsNoOverflow(2)->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_6_months':
                $this->startDate = now()->subMonthsNoOverflow(5)->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_year':
                $this->startDate = now()->subMonthsNoOverflow(11)->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
                break;
        }

        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['startDate', 'endDate'])) {
            $this->period = 'custom';
            $this->resetPage();
        }
    }

    public function render()
    {
        $business = Auth::user()->business;

        // 1. Overall Revenue (Accrual/Invoiced Basis)
        // Sum all invoices issued in the date range (excluding drafts and cancelled)
        $invoicedRevenue = Invoice::where('business_id', $business->id)
            ->whereBetween('invoice_date', [$this->startDate, $this->endDate])
            ->whereNotIn('status', ['draft', 'cancelled'])
            ->sum('grand_total');

        // Sum manual income from Cash Book (e.g. income not linked to an invoice - keep as cash basis)
        $manualIncome = CashBookEntry::where('business_id', $business->id)
            ->where('type', 'income')
            ->whereNull('invoice_id')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');

        $totalRevenue = (float) $invoicedRevenue + (float) $manualIncome;

        $totalExpenses = (float) Expense::where('business_id', $business->id)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');

        // 1b. Fixed vs Variable Costs Breakdown (F vs V Cost Centers)
        $fixedCosts = (float) Expense::where('business_id', $business->id)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where(function ($query) {
                $query->whereHas('accounting_category', function ($q) {
                    $q->where('cost_type', 'F');
                })->orWhereNull('category_id');
            })
            ->sum('amount');

        $variableCosts = (float) Expense::where('business_id', $business->id)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->whereHas('accounting_category', function ($q) {
                $q->where('cost_type', 'V');
            })
            ->sum('amount');

        $salesRequirement = $fixedCosts; // Minimum sales requirement to cover fixed overheads
        $netIncome = $totalRevenue - $totalExpenses;

        // 1c. Monthly Averages & Benchmark Calculations
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $daysDiff = max(1, $start->diffInDays($end) + 1);
        $monthsCount = max(1.0, round($daysDiff / 30.4375, 1));

        $avgMonthlyRevenue = $totalRevenue / $monthsCount;
        $avgMonthlyFixedCosts = $fixedCosts / $monthsCount;
        $avgMonthlyVariableCosts = $variableCosts / $monthsCount;
        $avgMonthlyTotalExpenses = $totalExpenses / $monthsCount;
        $avgMonthlyNetProfit = $netIncome / $monthsCount;

        $monthlyBenchmark = $avgMonthlyFixedCosts; // Minimum monthly sales needed to cover average monthly fixed costs
        $coveragePercent = ($fixedCosts > 0) ? round(($totalRevenue / $fixedCosts) * 100, 1) : ($totalRevenue > 0 ? 100 : 0);
        $gapToBenchmark = $totalRevenue - $fixedCosts; // Positive = Surplus, Negative = Deficit

        // 2. Customer Profitability (Invoices vs Linked Expenses)
        $clientProfitability = Client::where('business_id', $business->id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('company_name', 'like', '%' . $this->search . '%');
                });
            })
            ->with([
                'invoices' => function ($query) {
                    $query->whereBetween('invoice_date', [$this->startDate, $this->endDate])
                        ->whereNotIn('status', ['draft', 'cancelled']);
                }
            ])
            ->get()
            ->map(function ($client) {
                $sales = $client->invoices->sum('grand_total');
                $directCosts = Expense::where('client_id', $client->id)
                    ->whereBetween('date', [$this->startDate, $this->endDate])
                    ->sum('amount');

                return [
                    'id' => $client->id,
                    'name' => $client->company_name ?? $client->name,
                    'sales' => (float) $sales,
                    'costs' => (float) $directCosts,
                    'difference' => (float) ($sales - $directCosts),
                    'margin' => $sales > 0 ? (($sales - $directCosts) / $sales) * 100 : ($directCosts > 0 ? -100 : 0)
                ];
            })
            ->filter(fn($item) => $item['sales'] > 0 || $item['costs'] > 0)
            ->sortByDesc('difference');

        // 3. Product Profitability (Price vs Purchase Price) - Comprehensive List
        $productProfitability = Product::where('business_id', $business->id)
            ->get()
            ->map(function ($product) {
                $salesData = DB::table('invoice_items')
                    ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
                    ->where('invoice_items.product_id', $product->id)
                    ->whereNotIn('invoices.status', ['draft', 'cancelled'])
                    ->whereBetween('invoices.invoice_date', [$this->startDate, $this->endDate])
                    ->select(
                        DB::raw('SUM(invoice_items.quantity) as total_sold'),
                        DB::raw('SUM(invoice_items.total) as total_revenue')
                    )
                    ->first();

                $productDirectExpenses = Expense::where('product_id', $product->id)
                    ->whereBetween('date', [$this->startDate, $this->endDate])
                    ->sum('amount');

                $totalSold = (float) ($salesData->total_sold ?? 0);
                $totalRevenue = (float) ($salesData->total_revenue ?? 0);
                $purchaseCost = $totalSold * (float) ($product->purchase_price ?? 0);
                $totalCosts = (float) ($purchaseCost + $productDirectExpenses);

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sold' => $totalSold,
                    'sales' => $totalRevenue,
                    'costs' => $totalCosts,
                    'difference' => (float) ($totalRevenue - $totalCosts),
                    'margin' => $totalRevenue > 0 ? (($totalRevenue - $totalCosts) / $totalRevenue) * 100 : ($totalCosts > 0 ? -100 : 0)
                ];
            })
            ->filter(fn($item) => $item['sales'] > 0 || $item['costs'] > 0);

        // Capture revenue from items with NO product_id (Uncategorized/One-off items)
        $uncategorizedSales = DB::table('invoice_items')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->where('invoices.business_id', $business->id)
            ->whereNull('invoice_items.product_id')
            ->whereNotIn('invoices.status', ['draft', 'cancelled'])
            ->whereBetween('invoices.invoice_date', [$this->startDate, $this->endDate])
            ->sum('invoice_items.total');

        if ($uncategorizedSales > 0) {
            $productProfitability->push([
                'id' => null,
                'name' => __('Other / Custom Line Items'),
                'sold' => 0,
                'sales' => (float) $uncategorizedSales,
                'costs' => 0,
                'difference' => (float) $uncategorizedSales,
                'margin' => 100
            ]);
        }

        $productProfitability = $productProfitability->sortByDesc('difference');

        // Top Performers for Summary Overview
        $topClients = $clientProfitability->take(3);
        $topProducts = $productProfitability->take(3);

        return view('livewire.reports.profitability', [
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
            'fixedCosts' => $fixedCosts,
            'variableCosts' => $variableCosts,
            'salesRequirement' => $salesRequirement,
            'netIncome' => $netIncome,
            'monthsCount' => $monthsCount,
            'avgMonthlyRevenue' => $avgMonthlyRevenue,
            'avgMonthlyFixedCosts' => $avgMonthlyFixedCosts,
            'avgMonthlyVariableCosts' => $avgMonthlyVariableCosts,
            'avgMonthlyTotalExpenses' => $avgMonthlyTotalExpenses,
            'avgMonthlyNetProfit' => $avgMonthlyNetProfit,
            'monthlyBenchmark' => $monthlyBenchmark,
            'coveragePercent' => $coveragePercent,
            'gapToBenchmark' => $gapToBenchmark,
            'clientProfitability' => $clientProfitability,
            'productProfitability' => $productProfitability,
            'topClients' => $topClients,
            'topProducts' => $topProducts,
        ]);
    }
}