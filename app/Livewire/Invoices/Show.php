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
    public float $margin_percentage = 0;
    public bool $showPaidModal = false;
    public $paymentSource = 'bank';
    public $paymentDescription = '';

    protected array $rules = [
        'payment_amount' => 'required|numeric|min:0.01',
        'payment_method' => 'required|in:bank_transfer,credit_card,cash,check,paypal,stripe',
        'payment_date' => 'required|date',
    ];

    public function mount(Invoice $invoice): void
    {
        $this->authorize('view', $invoice);
        $this->invoice = $invoice->load(['items.product', 'payments', 'client', 'business', 'expenses']);
        $this->payment_date = now()->toDateString();
        $this->calculateProfitability();
    }

    public function calculateProfitability(): void
    {
        $this->total_expenses = (float) $this->invoice->expenses->sum('amount');
        $this->profit = (float) $this->invoice->grand_total - $this->total_expenses;
        $this->margin_percentage = $this->invoice->grand_total > 0
            ? ($this->profit / (float) $this->invoice->grand_total) * 100
            : 0;
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

    public function openPaidModal(): void
    {
        $this->payment_date = now()->format('Y-m-d');
        $this->paymentDescription = __('Payment for Invoice') . ' ' . $this->invoice->invoice_number;
        $this->showPaidModal = true;
    }

    public function closePaidModal(): void
    {
        $this->showPaidModal = false;
        $this->reset(['paymentSource', 'paymentDescription']);
    }

    public function markAsPaid(): void
    {
        $this->validate([
            'payment_date' => 'required|date',
            'paymentSource' => 'required|in:cash,bank',
            'paymentDescription' => 'required|string|max:255',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () {
            // Update Invoice Status
            $this->invoice->update([
                'status' => Invoice::STATUS_PAID,
                'amount_paid' => $this->invoice->grand_total,
                'amount_due' => 0,
            ]);

            // Create Payment History record
            Payment::create([
                'invoice_id' => $this->invoice->id,
                'amount' => $this->invoice->grand_total,
                'method' => $this->paymentSource === 'cash' ? 'cash' : 'bank_transfer',
                'date' => $this->payment_date,
                'notes' => $this->paymentDescription,
            ]);

            // Create Cash Book Entry
            \App\Models\CashBookEntry::create([
                'business_id' => $this->invoice->business_id,
                'date' => $this->payment_date,
                'document_date' => $this->invoice->invoice_date,
                'amount' => $this->invoice->grand_total,
                'type' => 'income',
                'source' => $this->paymentSource,
                'description' => $this->paymentDescription,
                'partner_name' => $this->invoice->client->company_name ?? $this->invoice->client->name,
                'reference_number' => $this->invoice->invoice_number,
                'invoice_id' => $this->invoice->id,
            ]);

            $this->invoice->deductInventory();
        });

        $this->closePaidModal();
        session()->flash('message', __('Invoice marked as paid and Cash Book entry created.'));
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

        \Illuminate\Support\Facades\DB::transaction(function () use ($amount) {
            Payment::create([
                'invoice_id' => $this->invoice->id,
                'amount' => $amount,
                'method' => $this->payment_method,
                'date' => $this->payment_date,
                'notes' => $this->payment_notes,
            ]);

            // Create Cash Book Entry for partial payment
            \App\Models\CashBookEntry::create([
                'business_id' => $this->invoice->business_id,
                'date' => $this->payment_date,
                'document_date' => $this->invoice->invoice_date,
                'amount' => $amount,
                'type' => 'income',
                'source' => in_array($this->payment_method, ['cash']) ? 'cash' : 'bank',
                'description' => $this->payment_notes ?: __('Partial payment for') . ' ' . $this->invoice->invoice_number,
                'partner_name' => $this->invoice->client->company_name ?? $this->invoice->client->name,
                'reference_number' => $this->invoice->invoice_number,
                'invoice_id' => $this->invoice->id,
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
        });

        $this->payment_amount = '';
        $this->payment_notes = '';
        $this->invoice->load('payments');
        session()->flash('message', __('Payment recorded and Cash Book entry created.'));
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
