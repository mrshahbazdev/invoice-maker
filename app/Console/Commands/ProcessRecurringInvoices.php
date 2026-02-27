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
        // We only clone invoices that are active (not cancelled or estimate)
        // For simplicity, we assume if it has is_recurring = true and a next_run_date <= today, it's eligible.
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
                // Calculate new dates based on parent's offset
                $issueDate = Carbon::today();

                // Keep the same payment window (e.g. net 30 days)
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

                // Update identifying info
                $newInvoice->invoice_number = $invoiceNumberService->generate($parentInvoice->business);
                $newInvoice->invoice_date = $issueDate;
                $newInvoice->due_date = $dueDate;
                $newInvoice->status = Invoice::STATUS_SENT; // Because we are automatically emailing it
                $newInvoice->amount_paid = 0; // Reset
                $newInvoice->amount_due = $parentInvoice->grand_total; // Reset
                $newInvoice->save();
                $newInvoice->refresh();

                // 3. Clone items
                foreach ($parentInvoice->items as $item) {
                    $newInvoice->items()->create($item->toArray());
                }

                $this->info("Created new invoice {$newInvoice->invoice_number} from {$parentInvoice->invoice_number}");

                // 4. Update the parent invoice's next_run_date
                $nextRun = Carbon::parse($parentInvoice->next_run_date);
                match ($parentInvoice->recurring_frequency) {
                    'weekly' => $nextRun->addWeek(),
                    'monthly' => $nextRun->addMonth(),
                    'quarterly' => $nextRun->addMonths(3),
                    'yearly' => $nextRun->addYear(),
                    default => $nextRun->addMonth(), // fallback
                };

                $parentInvoice->update([
                    'last_run_date' => Carbon::now(),
                    'next_run_date' => $nextRun,
                    'status' => Invoice::STATUS_SENT, // Mark original template as active/sent
                ]);

                // 5. Automatically Email the new Invoice
                if ($newInvoice->client && $newInvoice->client->email) {
                    $pdfContent = $pdfService->generate($newInvoice);

                    $templateService = new \App\Services\EmailTemplateService();
                    $template = $templateService->getParsedTemplate($newInvoice, 'invoice');

                    Mail::send([], [], function (Message $message) use ($newInvoice, $pdfContent, $template) {
                        $message->to($newInvoice->client->email)
                            ->subject($template['subject'])
                            ->html($template['body'])
                            ->attachData($pdfContent, "Invoice-{$newInvoice->invoice_number}.pdf", [
                                'mime' => 'application/pdf',
                            ]);

                        // Reply-To Business Email if configured
                        if ($newInvoice->business->email) {
                            $message->replyTo($newInvoice->business->email, $newInvoice->business->name);
                        }
                    });

                    $this->info("Emailed invoice to {$newInvoice->client->email}");
                }

                $count++;

            } catch (\Exception $e) {
                Log::error("Failed to process recurring invoice ID {$parentInvoice->id}: " . $e->getMessage());
                $this->error("Failed to process recurring invoice ID {$parentInvoice->id}");
            }
        }

        $this->info("Successfully processed {$count} recurring invoices.");
    }
}
