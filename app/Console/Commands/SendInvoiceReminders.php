<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Mail\InvoiceReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendInvoiceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated email reminders for upcoming and overdue invoices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting automated invoice reminders...');

        $today = now()->startOfDay();

        // 1. Get all sent (unpaid) invoices
        $invoices = Invoice::where('type', Invoice::TYPE_INVOICE)
            ->where('status', Invoice::STATUS_SENT)
            ->where('amount_due', '>', 0)
            ->with(['client', 'business'])
            ->get();

        /** @var Invoice $invoice */
        foreach ($invoices as $invoice) {
            $dueDate = $invoice->due_date->startOfDay();
            $diffInDays = $today->diffInDays($dueDate, false); // Positive if due_date is in future, negative if overdue

            $type = null;

            // Milestones logic
            if ($diffInDays === 3) {
                $type = 'upcoming'; // 3 days before due
            } elseif ($diffInDays === 0) {
                $type = 'due'; // Today
            } elseif ($diffInDays === -3 || $diffInDays === -7 || $diffInDays === -14) {
                $type = 'overdue'; // Overdue milestones
            }

            if ($type) {
                // Prevent duplicate reminders on the same day (shouldn't happen with daily schedule but good for safety)
                if ($invoice->last_reminder_sent_at && $invoice->last_reminder_sent_at->isToday()) {
                    continue;
                }

                $this->sendReminder($invoice, $type);
            }
        }

        $this->info('Finished sending reminders.');
    }

    protected function sendReminder(Invoice $invoice, string $type)
    {
        try {
            \App\Services\MailConfigurationService::getMailer($invoice->business)
                ->to($invoice->client->email)
                ->send(new InvoiceReminder($invoice, $type));

            $invoice->update([
                'last_reminder_sent_at' => now(),
            ]);

            $this->info("Reminder ({$type}) sent for Invoice #{$invoice->invoice_number} to {$invoice->client->email}");
            Log::info("Invoice Reminder Sent: Invoice #{$invoice->id}, Type: {$type}");
        } catch (\Exception $e) {
            $this->error("Failed to send reminder for Invoice #{$invoice->invoice_number}: " . $e->getMessage());
            Log::error("Failed to send invoice reminder: " . $e->getMessage());
        }
    }
}
