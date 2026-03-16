<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Invoice $invoice;
    public string $pdfContent;
    public ?string $customSubject;
    public ?string $customBody;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, string $pdfContent, ?string $customSubject = null, ?string $customBody = null)
    {
        $this->invoice = $invoice;
        $this->pdfContent = $pdfContent;
        $this->customSubject = $customSubject;
        $this->customBody = $customBody;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->customSubject ?? "OVERDUE ACCOUNT: Invoice {$this->invoice->invoice_number} from {$this->invoice->business->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->customBody) {
            return new Content(
                htmlString: $this->customBody,
            );
        }

        return new Content(
            markdown: 'emails.payment-reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn() => $this->pdfContent, "Invoice-{$this->invoice->invoice_number}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
