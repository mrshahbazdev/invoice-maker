<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\PdfGenerationService;
use App\Services\EmailTemplateService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class SendScheduledInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:send-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically send standard (non-recurring) invoices on their scheduled issue date.';

    /**
     * Execute the console command.
     */
    public function handle(PdfGenerationService $pdfService)
    {
        $this->info('Starting scheduled invoice sending...');

        $today = Carbon::today()->toDateString();

        // Find standard invoices scheduled for today (or earlier if missed)
        // that are still in 'draft' status.
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Invoice> $invoices */
        $invoices = Invoice::where('is_recurring', false)
            ->where('status', Invoice::STATUS_DRAFT)
            ->whereDate('invoice_date', '<=', $today)
            ->where('type', Invoice::TYPE_INVOICE)
            ->with(['items', 'client', 'business'])
            ->get();

        if ($invoices->isEmpty()) {
            $this->info('No scheduled invoices due for sending today.');
            return;
        }

        $count = 0;

        foreach ($invoices as $invoice) {
            try {
                if ($invoice->client && $invoice->client->email) {
                    $pdfContent = $pdfService->generate($invoice);

                    $templateService = new EmailTemplateService(); // Instantiated EmailTemplateService
                    $template = $templateService->getParsedTemplate($invoice, 'invoice'); // Get parsed template

                    Mail::send([], [], function (Message $message) use ($invoice, $pdfContent, $template) { // Added $template to use clause
                        $message->to($invoice->client->email)
                            ->subject($template['subject']) // Used template subject
                            ->html($template['body']) // Used template body
                            ->attachData($pdfContent, "Invoice-{$invoice->invoice_number}.pdf", [
                                'mime' => 'application/pdf',
                            ]);

                        // Reply-To Business Email if configured
                        if ($invoice->business->email) {
                            $message->replyTo($invoice->business->email, $invoice->business->name);
                        }
                    });

                    // Update status to sent so we don't send it again
                    $invoice->update(['status' => Invoice::STATUS_SENT]);

                    $this->info("Emailed scheduled invoice {$invoice->invoice_number} to {$invoice->client->email}");
                    $count++;
                }
            } catch (\Exception $e) {
                Log::error("Failed to send scheduled invoice ID {$invoice->id}: " . $e->getMessage());
                $this->error("Failed to send scheduled invoice ID {$invoice->id}");
            }
        }

        $this->info("Successfully sent {$count} scheduled invoices.");
    }
}
