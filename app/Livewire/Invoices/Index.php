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
