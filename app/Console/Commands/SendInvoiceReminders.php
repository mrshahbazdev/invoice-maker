<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Mail\PaymentReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\PdfGenerationService;

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
    protected $description = 'Send automated email reminders for overdue invoices';

    /**
     * Execute the console command.
     */
    public function handle(PdfGenerationService $pdfService)
    {
        $this->info('Starting automated overdue invoice reminders...');

        $today = now()->startOfDay();

        // 1. Get all sent or partial (unpaid) invoices that are overdue
        $invoices = Invoice::where('type', Invoice::TYPE_INVOICE)
            ->whereIn('status', [Invoice::STATUS_SENT, 'partial'])
            ->where('amount_due', '>', 0)
            ->where('due_date', '<', $today)
            ->whereHas('business', function ($query) {
                $query->where('enable_automated_reminders', true);
            })
            ->with(['client', 'business', 'items'])
            ->get();

        $count = 0;

        /** @var Invoice $invoice */
        foreach ($invoices as $invoice) {
            $intervalDays = $invoice->business->reminder_days_interval ?? 7;

            $shouldSend = false;

            if (is_null($invoice->last_reminder_sent_at)) {
                // Never sent a reminder yet. Send if today is >= due_date + interval
                $threshold = Carbon::parse($invoice->due_date)->addDays($intervalDays)->startOfDay();
                if ($today->greaterThanOrEqualTo($threshold)) {
                    $shouldSend = true;
                }
            } else {
                // We've sent one before. Send if today is >= last_reminder_sent_at + interval
                $threshold = Carbon::parse($invoice->last_reminder_sent_at)->addDays($intervalDays)->startOfDay();
                if ($today->greaterThanOrEqualTo($threshold)) {
                    $shouldSend = true;
                }
            }

            if ($shouldSend) {
                // Prevent duplicate reminders on the same day (shouldn't happen with daily schedule but good for safety)
                if ($invoice->last_reminder_sent_at && $invoice->last_reminder_sent_at->isToday()) {
                    continue;
                }

                $this->sendReminder($invoice, $pdfService);
                $count++;
            }
        }

        $this->info("Finished sending {$count} overdue reminders.");
    }

    protected function sendReminder(Invoice $invoice, PdfGenerationService $pdfService)
    {
        try {
            // Generate the PDF in real-time
            $pdfContent = $pdfService->generate($invoice);

            \App\Services\MailConfigurationService::getMailer($invoice->business)
                ->to($invoice->client->email)
                ->send(new PaymentReminderMail($invoice, $pdfContent));

            $invoice->update([
                'last_reminder_sent_at' => now(),
            ]);

            $this->info("Overdue Reminder sent for Invoice #{$invoice->invoice_number} to {$invoice->client->email}");
            Log::info("Payment Reminder Sent: Invoice #{$invoice->id}");
        } catch (\Exception $e) {
            $this->error("Failed to send reminder for Invoice #{$invoice->invoice_number}: " . $e->getMessage());
            Log::error("Failed to send payment reminder: " . $e->getMessage());
        }
    }
}
