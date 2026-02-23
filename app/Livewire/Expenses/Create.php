<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $source = 'cash';
    public $category_id = null;
    public $invoice_id = null;
    public $category = '';
    public $amount;
    public $date;
    public $description = '';
    public $receipt;
    public $posting_rule = '';
    public $partner_name = '';
    public $reference_number = '';

    protected $rules = [
        'source' => 'required|in:cash,bank',
        'category_id' => 'required|exists:accounting_categories,id',
        'invoice_id' => 'nullable|exists:invoices,id',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'description' => 'required|string|max:255',
        'partner_name' => 'nullable|string|max:255',
        'reference_number' => 'nullable|string|max:255',
        'receipt' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');

        // Ensure default categories exist for the business
        $this->ensureDefaultCategories();
    }

    protected function ensureDefaultCategories()
    {
        $business = Auth::user()->business;
        $defaults = [
            ['name' => 'Travel', 'type' => 'expense', 'posting_rule' => 'Requires receipt. Deductible if business related.'],
            ['name' => 'Office Supplies', 'type' => 'expense', 'posting_rule' => 'Small items under $250.'],
            ['name' => 'Software', 'type' => 'expense', 'posting_rule' => 'SaaS subscriptions and licenses.'],
            ['name' => 'Rent', 'type' => 'expense', 'posting_rule' => 'Monthly office rent.'],
        ];

        foreach ($defaults as $tmpl) {
            \App\Models\AccountingCategory::firstOrCreate(
                ['business_id' => $business->id, 'name' => $tmpl['name']],
                $tmpl
            );
        }
    }

    public function updatedCategoryId($value)
    {
        $category = \App\Models\AccountingCategory::find($value);
        $this->posting_rule = $category ? $category->posting_rule : '';
        $this->category = $category ? $category->name : '';
    }

    public function save()
    {
        $this->validate();

        $receiptPath = null;
        if ($this->receipt) {
            $receiptPath = $this->receipt->store('receipts', 'public');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($receiptPath) {
            $business = Auth::user()->business;

            $expense = \App\Models\Expense::create([
                'business_id' => $business->id,
                'category_id' => $this->category_id,
                'category' => $this->category,
                'amount' => $this->amount,
                'date' => $this->date,
                'description' => $this->description,
                'partner_name' => $this->partner_name,
                'reference_number' => $this->reference_number,
                'receipt_path' => $receiptPath,
                'invoice_id' => $this->invoice_id,
            ]);

            // Create Cash Book Entry
            \App\Models\CashBookEntry::create([
                'business_id' => $business->id,
                'date' => $this->date,
                'document_date' => $this->date,
                'amount' => $this->amount,
                'type' => 'expense',
                'source' => $this->source,
                'description' => $this->description,
                'partner_name' => $this->partner_name,
                'reference_number' => $this->reference_number,
                'category_id' => $this->category_id,
                'invoice_id' => $this->invoice_id,
                'expense_id' => $expense->id,
            ]);
        });

        session()->flash('message', 'Expense and Cash Book entry recorded successfully.');
        return redirect()->route('expenses.index');
    }

    public function render()
    {
        $business = Auth::user()->business;
        $categories = $business->accounting_categories ?? \App\Models\AccountingCategory::where('business_id', $business->id)->get();
        $invoices = $business->invoices()->orderBy('created_at', 'desc')->get();

        return view('livewire.expenses.create', [
            'categories' => $categories,
            'invoices' => $invoices,
        ]);
    }
}
