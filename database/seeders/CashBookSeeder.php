<?php

namespace Database\Seeders;

use App\Models\AccountingCategory;
use App\Models\Business;
use App\Models\CashBookEntry;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CashBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user and their business
        $user = User::first();
        if (!$user)
            return;

        $business = $user->business;
        if (!$business)
            return;

        // Ensure categories exist
        $this->ensureCategories($business);

        // 1. Create dummy income entries
        $this->seedIncome($business);

        // 2. Create dummy expense entries
        $this->seedExpenses($business);

        $this->command->info('Cash Book dummy data seeded successfully for: ' . $business->name);
    }

    protected function ensureCategories($business)
    {
        $categories = [
            ['name' => 'Bürobedarf', 'type' => 'expense', 'booking_account' => '4930'],
            ['name' => 'Reisekosten', 'type' => 'expense', 'booking_account' => '4660'],
            ['name' => 'Software / SaaS', 'type' => 'expense', 'booking_account' => '4964'],
            ['name' => 'Miete', 'type' => 'expense', 'booking_account' => '4210'],
        ];

        foreach ($categories as $cat) {
            AccountingCategory::firstOrCreate(
                ['business_id' => $business->id, 'name' => $cat['name']],
                $cat
            );
        }
    }

    protected function seedIncome($business)
    {
        // Get some invoices
        $invoices = Invoice::where('business_id', $business->id)->limit(3)->get();

        foreach ($invoices as $index => $invoice) {
            /** @var Invoice $invoice */

            // Check if entry already exists for this invoice
            if (CashBookEntry::where('invoice_id', $invoice->id)->exists()) {
                continue;
            }

            CashBookEntry::create([
                'business_id' => $business->id,
                'invoice_id' => $invoice->id,
                'amount' => $invoice->grand_total,
                'type' => 'income',
                'source' => $index % 2 == 0 ? 'bank' : 'cash',
                'date' => now()->subDays(rand(1, 30)),
                'document_date' => $invoice->invoice_date,
                'description' => 'Zahlung für Rechnung ' . $invoice->invoice_number,
                'partner_name' => $invoice->client->company_name ?? $invoice->client->name,
                'reference_number' => $invoice->invoice_number,
            ]);

            $invoice->update(['status' => 'paid']);
        }
    }

    protected function seedExpenses($business)
    {
        $categories = AccountingCategory::where('business_id', $business->id)->where('type', 'expense')->get();

        $expenseData = [
            ['partner' => 'Amazon Business', 'ref' => 'RE-2026-99AA', 'desc' => 'Druckerpapier und Toner', 'amount' => 85.50],
            ['partner' => 'Deutsche Bahn', 'ref' => 'T-882211', 'desc' => 'Fahrkarte Berlin-München', 'amount' => 124.90],
            ['partner' => 'Adobe Systems', 'ref' => 'INV-001292', 'desc' => 'Creative Cloud Subscription', 'amount' => 59.99],
            ['partner' => 'Wework', 'ref' => 'RENT-MARCH', 'desc' => 'Miete März 2026', 'amount' => 850.00],
        ];

        foreach ($expenseData as $index => $data) {
            $cat = $categories->random();
            $date = now()->subDays(rand(1, 15));

            // Check if expense with this reference already exists for this business
            $existingExpense = Expense::where('business_id', $business->id)
                ->where('reference_number', $data['ref'])
                ->first();

            if ($existingExpense) {
                continue;
            }

            $expense = Expense::create([
                'business_id' => $business->id,
                'category_id' => $cat->id,
                'category' => $cat->name,
                'amount' => $data['amount'],
                'date' => $date,
                'description' => $data['desc'],
                'partner_name' => $data['partner'],
                'reference_number' => $data['ref'],
            ]);

            CashBookEntry::create([
                'business_id' => $business->id,
                'expense_id' => $expense->id,
                'category_id' => $cat->id,
                'amount' => $data['amount'],
                'type' => 'expense',
                'source' => $index % 2 == 0 ? 'bank' : 'cash',
                'date' => $date,
                'document_date' => $date,
                'description' => $data['desc'],
                'partner_name' => $data['partner'],
                'reference_number' => $data['ref'],
            ]);
        }
    }
}
