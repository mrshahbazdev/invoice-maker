@component('mail::message')
# Payment Reminder: Overdue Invoice {{ $invoice->invoice_number }}

Hi {{ $invoice->client->name }},

This is a friendly reminder that your invoice **{{ $invoice->invoice_number }}** from **{{ $invoice->business->name }}**
is now overdue.

**Invoice Details:**
- **Invoice Number:** {{ $invoice->invoice_number }}
- **Issue Date:** {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}
- **Due Date:** {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
- **Amount Due:** {{ $invoice->business->currency_symbol }}{{ number_format((float) $invoice->amount_due, 2) }}

If you have already made this payment, please disregard this email. Otherwise, please remit payment as soon as possible.

@if(!$invoice->isEstimate() && $invoice->status !== 'paid' && !empty($invoice->uuid) && !empty($invoice->business->stripe_public_key) && !empty($invoice->business->stripe_secret_key))
    @component('mail::button', ['url' => route('payment.checkout', ['invoice' => $invoice->uuid])])
    Pay Invoice Online Now
    @endcomponent
@else
    @component('mail::button', ['url' => route('invoices.public.show', $invoice->uuid)])
    View Invoice Online
    @endcomponent
@endif

We have also attached a PDF copy of your invoice for your records.

<br>
Thank you,<br>
{{ $invoice->business->name }}
@endcomponent