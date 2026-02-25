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
use Livewire\WithPagination;

class Profitability extends Component
{
 use WithPagination;
 public $search = '';
 public $startDate;
 public $endDate;

 public function mount()
 {
 $this->startDate = now()->startOfMonth()->format('Y-m-d');
 $this->endDate = now()->endOfMonth()->format('Y-m-d');
 }

 public function updated($property)
 {
 if (in_array($property, ['startDate', 'endDate'])) {
 $this->resetPage(); // If pagination is used later
 }
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
 ->when($this->search, function ($query) {
 $query->where(function ($q) {
 $q->where('name', 'like', '%' . $this->search . '%')
 ->orWhere('company_name', 'like', '%' . $this->search . '%');
 });
 })
 ->with([
 'invoices' => function ($query) {
 $query->whereBetween('invoice_date', [$this->startDate, $this->endDate])
 ->where('status', 'paid');
 }
 ])
 ->get()
 ->map(function ($client) {
 $sales = $client->invoices->sum('grand_total');

 // Sum ALL direct expenses linked to this client in the date range
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
 ->sortByDesc('difference');

 // 3. Product Profitability (Price vs Purchase Price) - Comprehensive List
 $productProfitability = Product::where('business_id', $business->id)
 ->when($this->search, function ($query) {
 $query->where('name', 'like', '%' . $this->search . '%');
 })
 ->get()
 ->map(function ($product) {
 // Sum sales for this product in range
 $salesData = DB::table('invoice_items')
 ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
 ->where('invoice_items.product_id', $product->id)
 ->where('invoices.status', 'paid')
 ->whereBetween('invoices.invoice_date', [$this->startDate, $this->endDate])
 ->select(
 DB::raw('SUM(invoice_items.quantity) as total_sold'),
 DB::raw('SUM(invoice_items.total) as total_revenue')
 )
 ->first();

 // Sum direct expenses linked to this product (e.g. specific stock purchases)
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
 ->sortByDesc('difference');

 // Top Performers for Summary Overview
 $topClients = $clientProfitability->take(3);
 $topProducts = $productProfitability->take(3);

 return view('livewire.reports.profitability', [
 'totalRevenue' => $totalRevenue,
 'totalExpenses' => $totalExpenses,
 'netIncome' => $netIncome,
 'clientProfitability' => $clientProfitability,
 'productProfitability' => $productProfitability,
 'topClients' => $topClients,
 'topProducts' => $topProducts,
 ]);
 }
}
