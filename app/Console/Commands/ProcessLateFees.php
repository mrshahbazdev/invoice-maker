<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessLateFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-late-fees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Applies a late fee percentage to overdue invoices for businesses that have this enabled.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting late fee processing...");

        $businesses = \App\Models\Business::where('late_fee_percentage', '>', 0)->get();
        $processedCount = 0;

        foreach ($businesses as $business) {
            $percentage = (float) $business->late_fee_percentage;

            $overdueInvoices = \App\Models\Invoice::where('business_id', $business->id)
                ->where('type', \App\Models\Invoice::TYPE_INVOICE)
                ->where('status', \App\Models\Invoice::STATUS_OVERDUE)
                ->where('amount_due', '>', 0)
                ->get();

            foreach ($overdueInvoices as $invoice) {
                if (!$invoice->due_date || !$invoice->due_date->isPast()) {
                    continue;
                }

                $lastFee = $invoice->items()
                    ->where('description', 'like', 'Late Payment Fee%')
                    ->latest()
                    ->first();

                $shouldApply = false;

                if (!$lastFee) {
                    $shouldApply = true;
                } else {
                    if ($lastFee->created_at->diffInDays(now()) >= 30) {
                        $shouldApply = true;
                    }
                }

                if ($shouldApply) {
                    $feeAmount = round($invoice->amount_due * ($percentage / 100), 2);

                    if ($feeAmount > 0) {
                        $invoice->items()->create([
                            'description' => "Late Payment Fee ({$percentage}%)",
                            'quantity' => 1,
                            'unit_price' => $feeAmount,
                            'tax_rate' => 0,
                            'tax_amount' => 0,
                            'discount' => 0,
                            'total' => $feeAmount,
                        ]);

                        $invoice->subtotal += $feeAmount;
                        $invoice->grand_total += $feeAmount;
                        $invoice->amount_due += $feeAmount;
                        $invoice->save();

                        \App\Models\InvoiceComment::create([
                            'invoice_id' => $invoice->id,
                            'user_id' => $business->user_id ?? 1,
                            'comment' => "Automated Late Fee of {$feeAmount} {$invoice->currency} applied.",
                            'is_internal' => true,
                        ]);

                        if ($business->user) {
                            $business->user->notify(new \App\Notifications\LateFeeAppliedNotification($invoice));
                        }

                        $processedCount++;
                        $this->line("Applied late fee to Invoice #{$invoice->invoice_number}");
                    }
                }
            }
        }

        $this->info("Late fee processing completed. Applied to {$processedCount} invoices.");
    }
}
