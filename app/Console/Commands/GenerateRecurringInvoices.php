<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Services\InvoiceNumberService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateRecurringInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:generate-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new draft invoices from recurring templates';

    /**
     * Execute the console command.
     */
    public function handle(InvoiceNumberService $invoiceNumberService)
    {
        $this->info('Starting recurring invoice generation...');

        $recurringInvoices = Invoice::where('is_recurring', true)
            ->whereNotNull('recurring_frequency')
            ->where(function ($query) {
                $query->whereNull('next_run_date')
                    ->orWhere('next_run_date', '<=', now()->toDateString());
            })
            ->get();

        if ($recurringInvoices->isEmpty()) {
            $this->info('No recurring invoices to process.');
            return;
        }

        /** @var Invoice $template */
        foreach ($recurringInvoices as $template) {
            DB::transaction(function () use ($template, $invoiceNumberService) {
                // 1. Calculate dates for the new invoice
                $today = now();
                $diffInDays = $template->invoice_date->diffInDays($template->due_date);
                $newDueDate = $today->copy()->addDays($diffInDays);

                // 2. Create the new invoice
                $newInvoice = Invoice::create([
                    'business_id' => $template->business_id,
                    'client_id' => $template->client_id,
                    'template_id' => $template->template_id,
                    'invoice_number' => $invoiceNumberService->generate($template->business),
                    'status' => Invoice::STATUS_DRAFT,
                    'invoice_date' => $today->toDateString(),
                    'due_date' => $newDueDate->toDateString(),
                    'notes' => $template->notes,
                    'currency' => $template->currency,
                    'type' => Invoice::TYPE_INVOICE, // Recurring always generates an invoice
                    'subtotal' => $template->subtotal,
                    'tax_total' => $template->tax_total,
                    'discount' => $template->discount,
                    'grand_total' => $template->grand_total,
                    'amount_paid' => 0,
                    'amount_due' => $template->grand_total,
                    'is_recurring' => false, // The child is NOT recurring itself
                ]);

                // 3. Clone items
                foreach ($template->items as $item) {
                    $newInvoice->items()->create([
                        'product_id' => $item->product_id,
                        'description' => $item->description,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'tax_rate' => $item->tax_rate,
                        'tax_amount' => $item->tax_amount,
                        'discount' => $item->discount,
                        'total' => $item->total,
                    ]);
                }

                // 4. Update the template's next run date
                $template->update([
                    'last_run_date' => $today->toDateString(),
                    'next_run_date' => $template->calculateNextRunDate(),
                ]);

                $this->info("Generated invoice {$newInvoice->invoice_number} from template {$template->invoice_number}");
                Log::info("Recurring invoice generated: Template {$template->id} -> New Invoice {$newInvoice->id}");
            });
        }

        $this->info('Recurring invoice generation completed.');
    }
}
