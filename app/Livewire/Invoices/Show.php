<?php

namespace App\Livewire\Invoices;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Services\PdfGenerationService;

class Show extends Component
{
    public Invoice $invoice;
    public string $payment_amount = '';
    public string $payment_method = 'bank_transfer';
    public string $payment_date = '';
    public string $payment_notes = '';

    protected array $rules = [
        'payment_amount' => 'required|numeric|min:0.01',
        'payment_method' => 'required|in:bank_transfer,credit_card,cash,check,paypal,stripe',
        'payment_date' => 'required|date',
    ];

    public function mount(Invoice $invoice): void
    {
        $this->authorize('view', $invoice);
        $this->invoice = $invoice->load(['items.product', 'payments', 'client', 'business']);
        $this->payment_date = now()->toDateString();
    }

    public function markAsSent(): void
    {
        $this->invoice->update(['status' => Invoice::STATUS_SENT]);
        $this->invoice->deductInventory();
        session()->flash('message', ($this->invoice->isEstimate() ? 'Estimate' : 'Invoice') . ' marked as sent.');
    }

    public function sendEmail(PdfGenerationService $pdfService): void
    {
        if (!$this->invoice->client->email) {
            session()->flash('error', 'Client does not have an email address.');
            return;
        }

        $pdfContent = $pdfService->generate($this->invoice);

        \App\Services\MailConfigurationService::getMailer($this->invoice->business)
            ->to($this->invoice->client->email)
            ->send(new InvoiceMail($this->invoice, $pdfContent));

        if ($this->invoice->status === Invoice::STATUS_DRAFT) {
            $this->invoice->update(['status' => Invoice::STATUS_SENT]);
            $this->invoice->deductInventory();
        }

        session()->flash('message', ($this->invoice->isEstimate() ? 'Estimate' : 'Invoice') . ' emailed successfully to ' . $this->invoice->client->email);
    }

    public function convertToInvoice(): void
    {
        if (!$this->invoice->isEstimate()) {
            return;
        }

        $this->invoice->update([
            'type' => Invoice::TYPE_INVOICE,
            'status' => Invoice::STATUS_DRAFT,
        ]);

        session()->flash('message', 'Estimate converted to Invoice successfully.');
    }

    public function markAsPaid(): void
    {
        $this->invoice->update([
            'status' => Invoice::STATUS_PAID,
            'amount_paid' => $this->invoice->grand_total,
            'amount_due' => 0,
        ]);
        $this->invoice->deductInventory();
        session()->flash('message', 'Invoice marked as paid.');
    }

    public function markAsOverdue(): void
    {
        $this->invoice->update(['status' => Invoice::STATUS_OVERDUE]);
        session()->flash('message', 'Invoice marked as overdue.');
    }

    public function cancelInvoice(): void
    {
        $this->invoice->update(['status' => Invoice::STATUS_CANCELLED]);
        session()->flash('message', ($this->invoice->isEstimate() ? 'Estimate' : 'Invoice') . ' cancelled.');
    }

    public function recordPayment(): void
    {
        $this->validate();

        $amount = (float) $this->payment_amount;

        if ($amount > $this->invoice->amount_due) {
            session()->flash('error', 'Payment amount cannot exceed due amount.');
            return;
        }

        Payment::create([
            'invoice_id' => $this->invoice->id,
            'amount' => $amount,
            'method' => $this->payment_method,
            'date' => $this->payment_date,
            'notes' => $this->payment_notes,
        ]);

        $totalPaid = $this->invoice->payments->sum('amount') + $amount;
        $this->invoice->update([
            'amount_paid' => $totalPaid,
            'amount_due' => $this->invoice->grand_total - $totalPaid,
        ]);

        if ($this->invoice->amount_due <= 0) {
            $this->invoice->update(['status' => Invoice::STATUS_PAID]);
            $this->invoice->deductInventory();
        }

        $this->payment_amount = '';
        $this->payment_notes = '';
        $this->invoice->load('payments');
        session()->flash('message', 'Payment recorded successfully.');
    }

    public function deletePayment(int $paymentId): void
    {
        $payment = $this->invoice->payments()->findOrFail($paymentId);
        $payment->delete();

        $totalPaid = $this->invoice->payments->sum('amount');
        $this->invoice->update([
            'amount_paid' => $totalPaid,
            'amount_due' => $this->invoice->grand_total - $totalPaid,
        ]);

        if ($totalPaid < $this->invoice->grand_total) {
            $this->invoice->update(['status' => Invoice::STATUS_SENT]);
        }

        $this->invoice->load('payments');
        session()->flash('message', 'Payment deleted successfully.');
    }

    public function render()
    {
        return view('livewire.invoices.show');
    }
}
