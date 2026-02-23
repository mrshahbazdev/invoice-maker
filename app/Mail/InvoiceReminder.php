<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceReminder extends Mailable
{
    use Queueable, SerializesModels;

    public Invoice $invoice;
    public string $type;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, string $type = 'upcoming')
    {
        $this->invoice = $invoice;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match ($this->type) {
            'upcoming' => "Reminder: Your invoice from {$this->invoice->business->name} is due soon",
            'due' => "Action Required: Your invoice from {$this->invoice->business->name} is due today",
            'overdue' => "Overdue: Your invoice from {$this->invoice->business->name} is now late",
            default => "Invoice Reminder from {$this->invoice->business->name}",
        };

        $fromAddress = $this->invoice->business->smtp_from_address ?: config('mail.from.address');
        $fromName = $this->invoice->business->smtp_from_name ?: $this->invoice->business->name;

        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($fromAddress, $fromName),
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
