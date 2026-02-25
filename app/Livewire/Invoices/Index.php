<?php

namespace App\Livewire\Invoices;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $sortBy = 'invoice_date';
    public string $sortDirection = 'desc';

    // Mark as Paid State
    public bool $showPaidModal = false;
    public $selectedInvoiceId;
    public $paymentDate;
    public $paymentSource = 'bank';
    public $paymentDescription = '';

    public function sortBy(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function delete(int $id): void
    {
        $invoice = Auth::user()->business->invoices()->findOrFail($id);
        $invoice->delete();
        session()->flash('message', 'Invoice deleted successfully.');
    }

    public function openPaidModal(int $id): void
    {
        $invoice = Auth::user()->business->invoices()->findOrFail($id);
        $this->selectedInvoiceId = $id;
        $this->paymentDate = now()->format('Y-m-d');
        $this->paymentDescription = __('Payment for Invoice') . ' ' . $invoice->invoice_number;
        $this->showPaidModal = true;
    }

    public function closePaidModal(): void
    {
        $this->showPaidModal = false;
        $this->reset(['selectedInvoiceId', 'paymentDate', 'paymentSource', 'paymentDescription']);
    }

    public function markAsPaid(): void
    {
        $this->validate([
            'paymentDate' => 'required|date',
            'paymentSource' => 'required|in:cash,bank',
            'paymentDescription' => 'required|string|max:255',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () {
            $invoice = Auth::user()->business->invoices()->findOrFail($this->selectedInvoiceId);

            // Update Invoice Status
            $invoice->update([
                'status' => \App\Models\Invoice::STATUS_PAID,
                'amount_paid' => $invoice->grand_total,
                'amount_due' => 0,
            ]);

            // Create Payment History record
            \App\Models\Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $invoice->grand_total,
                'method' => $this->paymentSource === 'cash' ? 'cash' : 'bank_transfer',
                'date' => $this->paymentDate,
                'notes' => $this->paymentDescription,
            ]);

            // Create Cash Book Entry
            \App\Models\CashBookEntry::create([
                'business_id' => Auth::user()->business_id,
                'date' => $this->paymentDate,
                'document_date' => $invoice->invoice_date,
                'amount' => $invoice->grand_total,
                'type' => 'income',
                'source' => $this->paymentSource,
                'description' => $this->paymentDescription,
                'partner_name' => $invoice->client->company_name ?? $invoice->client->name,
                'reference_number' => $invoice->invoice_number,
                'invoice_id' => $invoice->id,
            ]);
        });

        $this->closePaidModal();
        session()->flash('message', __('Invoice marked as paid and Cash Book entry created.'));
    }

    public function render()
    {
        $query = Auth::user()->business->invoices()->where('type', Invoice::TYPE_INVOICE)->with('client');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($cq) {
                        $cq->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('company_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $invoices = $query->orderBy($this->sortBy, $this->sortDirection)->paginate(10);

        return view('livewire.invoices.index', compact('invoices'));
    }
}
