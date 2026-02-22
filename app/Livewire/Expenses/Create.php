<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $category = '';
    public $amount;
    public $date;
    public $description = '';
    public $receipt;

    protected $rules = [
        'category' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'description' => 'required|string|max:255',
        'receipt' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        $receiptPath = null;
        if ($this->receipt) {
            $receiptPath = $this->receipt->store('receipts', 'public');
        }

        Expense::create([
            'business_id' => Auth::user()->business->id,
            'category' => $this->category,
            'amount' => $this->amount,
            'date' => $this->date,
            'description' => $this->description,
            'receipt_path' => $receiptPath,
        ]);

        session()->flash('message', 'Expense recorded successfully.');
        return redirect()->route('expenses.index');
    }

    public function render()
    {
        $recentCategories = Auth::user()->business->expenses()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('livewire.expenses.create', [
            'recentCategories' => $recentCategories,
        ]);
    }
}
