<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Expense $expense;
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
        'receipt' => 'nullable|image|max:2048',
    ];

    public function mount(Expense $expense)
    {
        $this->authorize('update', $expense);
        $this->expense = $expense;
        $this->category = $expense->category;
        $this->amount = $expense->amount;
        $this->date = $expense->date->format('Y-m-d');
        $this->description = $expense->description;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'category' => $this->category,
            'amount' => $this->amount,
            'date' => $this->date,
            'description' => $this->description,
        ];

        if ($this->receipt) {
            // Delete old receipt if exists
            if ($this->expense->receipt_path) {
                Storage::disk('public')->delete($this->expense->receipt_path);
            }
            $data['receipt_path'] = $this->receipt->store('receipts', 'public');
        }

        $this->expense->update($data);

        session()->flash('message', 'Expense updated successfully.');
        return redirect()->route('expenses.index');
    }

    public function render()
    {
        $recentCategories = Auth::user()->business->expenses()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('livewire.expenses.edit', [
            'recentCategories' => $recentCategories,
        ]);
    }
}
