<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function mount()
    {
        if (Auth::user()->role === 'client') {
            return redirect()->route('client.dashboard');
        }
    }

    public function render()
    {
        $business = Auth::user()->business;

        $stats = [
            'total_invoices' => $business->invoices()->count(),
            'paid_invoices' => $business->invoices()->where('status', Invoice::STATUS_PAID)->count(),
            'pending_invoices' => $business->invoices()->where('status', Invoice::STATUS_SENT)->count(),
            'overdue_invoices' => $business->invoices()->where('status', Invoice::STATUS_OVERDUE)->count(),
            'total_revenue' => $business->invoices()->where('status', Invoice::STATUS_PAID)->sum('grand_total'),
            'total_expenses' => $business->expenses()->sum('amount'),
            'net_profit' => $business->invoices()->where('status', Invoice::STATUS_PAID)->sum('grand_total') - $business->expenses()->sum('amount'),
            'pending_amount' => $business->invoices()->whereIn('status', [Invoice::STATUS_SENT, Invoice::STATUS_OVERDUE])->sum('amount_due'),
            'total_clients' => $business->clients()->count(),
            'recent_payments' => $business->invoices()
                ->whereHas('payments')
                ->with(['payments', 'client'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        $recentInvoices = $business->invoices()
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        $revenueByMonthData = $business->invoices()
            ->where('status', Invoice::STATUS_PAID)
            ->whereYear('invoice_date', now()->year)
            ->selectRaw('MONTH(invoice_date) as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $revenueByMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueByMonth[$i] = (float) ($revenueByMonthData[$i] ?? 0);
        }

        $expensesByMonthData = $business->expenses()
            ->whereYear('date', now()->year)
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $expensesByMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $expensesByMonth[$i] = (float) ($expensesByMonthData[$i] ?? 0);
        }

        $expensesByCategory = $business->expenses()
            ->selectRaw('category, sum(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $maxAmount = max(
            collect($revenueByMonth)->max() ?: 0,
            collect($expensesByMonth)->max() ?: 0,
            100 // Minimum floor for scaling
        );

        return view('livewire.dashboard', compact('stats', 'recentInvoices', 'revenueByMonth', 'expensesByMonth', 'expensesByCategory', 'maxAmount'));
    }
}
