<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, string $pdfContent)
    {
        $this->invoice = $invoice;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromAddress = $this->invoice->business->smtp_from_address ?: config('mail.from.address');
        $fromName = $this->invoice->business->smtp_from_name ?: $this->invoice->business->name;

        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($fromAddress, $fromName),
            subject: 'Invoice ' . $this->invoice->invoice_number . ' from ' . $this->invoice->business->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
            with: [
                'businessName' => $this->invoice->business->name,
                'clientName' => $this->invoice->client->name,
                'amountDue' => $this->invoice->amount_due,
                'dueDate' => $this->invoice->due_date->format('M d, Y'),
                'publicLink' => \Illuminate\Support\Facades\URL::signedRoute('invoices.public.show', ['invoice' => $this->invoice->id]),
            ],
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
            Attachment::fromData(fn() => $this->pdfContent, $this->invoice->invoice_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
