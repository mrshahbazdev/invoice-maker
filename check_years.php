<?php
include 'vendor/autoload.php';
$app = include 'bootstrap/app.php';
$app->make(Illuminate\Foundation\Console\Kernel::class)->bootstrap();

use App\Models\Invoice;
use App\Models\Expense;

$business = App\Models\Business::first();
if (!$business) {
    die("No business found\n");
}

echo "Business: {$business->name}\n";

$revenueByMonth = $business->invoices()
    ->where('status', Invoice::STATUS_PAID)
    ->whereYear('invoice_date', now()->year)
    ->get()
    ->groupBy(function ($invoice) {
        return (int) $invoice->invoice_date->format('n');
    })
    ->map(fn($invoices) => $invoices->sum('grand_total'))
    ->toArray();

echo "Revenue by Month:\n";
print_r($revenueByMonth);

$expensesByMonth = $business->expenses()
    ->whereYear('date', now()->year)
    ->get()
    ->groupBy(fn($expense) => (int) $expense->date->format('n'))
    ->map(fn($expenses) => $expenses->sum('amount'))
    ->toArray();

echo "\nExpenses by Month:\n";
print_r($expensesByMonth);

echo "\nMax Revenue: " . (max($revenueByMonth ?: [1])) . "\n";
echo "Max Expense: " . (max($expensesByMonth ?: [1])) . "\n";

$totalInvoices = $business->invoices()->count();
echo "\nTotal Invoices for Business: $totalInvoices\n";
$paidInvoices = $business->invoices()->where('status', Invoice::STATUS_PAID)->count();
echo "Paid Invoices for Business: $paidInvoices\n";

$allExpenses = $business->expenses()->get();
echo "\nTotal Expenses for Business: " . $allExpenses->count() . "\n";
foreach ($allExpenses as $ex) {
    echo "- Expense ID {$ex->id}: Amount {$ex->amount}, Date {$ex->date}\n";
}
