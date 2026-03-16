<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\PdfGenerationService;
use App\Services\InvoiceNumberService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class ProcessRecurringInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-recurring-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes scheduled recurring invoices, generating new ones and emailing clients.';

    /**
     * Execute the console command.
     */
    public function handle(PdfGenerationService $pdfService, InvoiceNumberService $invoiceNumberService)
    {
        $this->info('Starting recurring invoice processing...');

        $today = Carbon::today()->toDateString();

        // 1. Find all eligible recurring invoices
        $invoices = Invoice::where('is_recurring', true)
            ->whereNotNull('next_run_date')
            ->whereDate('next_run_date', '<=', $today)
            ->whereNotIn('status', [Invoice::STATUS_CANCELLED])
            ->where('type', 'invoice')
            ->with(['items', 'client', 'business'])
            ->get();

        if ($invoices->isEmpty()) {
            $this->info('No recurring invoices due for processing today.');
            return;
        }

        $count = 0;

        foreach ($invoices as $parentInvoice) {
            try {
                \Illuminate\Support\Facades\DB::transaction(function () use ($parentInvoice, $pdfService, $invoiceNumberService, &$count) {
                    // Calculate new dates
                    $issueDate = Carbon::today();
                    $originalIssue = Carbon::parse($parentInvoice->invoice_date);
                    $originalDue = Carbon::parse($parentInvoice->due_date);
                    $diffInDays = $originalIssue->diffInDays($originalDue);
                    $dueDate = $issueDate->copy()->addDays($diffInDays);

                    // 2. Clone the invoice
                    $newInvoice = $parentInvoice->replicate([
                        'is_recurring',
                        'recurring_frequency',
                        'next_run_date',
                        'last_run_date',
                        'last_reminder_sent_at'
                    ]);

                    $newInvoice->invoice_number = $invoiceNumberService->generate($parentInvoice->business);
                    $newInvoice->invoice_date = $issueDate;
                    $newInvoice->due_date = $dueDate;
                    $newInvoice->status = Invoice::STATUS_SENT;
                    $newInvoice->amount_paid = 0;
                    $newInvoice->amount_due = $parentInvoice->grand_total;
                    
                    if (!$newInvoice->save()) {
                        throw new \Exception("Failed to save new invoice copy for #{$parentInvoice->invoice_number}");
                    }

                    // 3. Clone items
                    foreach ($parentInvoice->items as $item) {
                        $newInvoice->items()->create($item->toArray());
                    }

                    // 4. Update the parent invoice's next_run_date
                    $nextRun = Carbon::parse($parentInvoice->next_run_date);
                    match ($parentInvoice->recurring_frequency) {
                        'weekly' => $nextRun->addWeek(),
                        'monthly' => $nextRun->addMonth(),
                        'quarterly' => $nextRun->addMonths(3),
                        'yearly' => $nextRun->addYear(),
                        default => $nextRun->addMonth(),
                    };

                    $parentInvoice->update([
                        'last_run_date' => Carbon::now(),
                        'next_run_date' => $nextRun,
                        // Keep as draft so it remains a "template"
                        'status' => Invoice::STATUS_DRAFT,
                    ]);

                    $this->info("Created new invoice {$newInvoice->invoice_number} from {$parentInvoice->invoice_number}");

                    // 5. Automatically Email the new Invoice using Business Mailer
                    if ($newInvoice->client && $newInvoice->client->email) {
                        $pdfContent = $pdfService->generate($newInvoice);
                        $templateService = new \App\Services\EmailTemplateService();
                        $template = $templateService->getParsedTemplate($newInvoice, 'invoice');

                        $mailer = \App\Services\MailConfigurationService::getMailer($newInvoice->business);
                        
                        // Ensure From address is set
                        $fromAddress = $newInvoice->business->smtp_from_address ?? $newInvoice->business->email ?? config('mail.from.address');
                        $fromName = $newInvoice->business->smtp_from_name ?? $newInvoice->business->name ?? config('mail.from.name');

                        $mailer->to($newInvoice->client->email)
                            ->from($fromAddress, $fromName)
                            ->send(new \App\Mail\PaymentReminderMail($newInvoice, $pdfContent, $template['subject'], $template['body']));

                        $this->info("Emailed invoice to {$newInvoice->client->email}");
                    }

                    $count++;
                });

            } catch (\Exception $e) {
                Log::error("Failed to process recurring invoice ID {$parentInvoice->id}: " . $e->getMessage());
                $this->error("Failed to process recurring invoice ID {$parentInvoice->id}: " . $e->getMessage());
            }
        }

        $this->info("Successfully processed {$count} recurring invoices.");
    }
}

