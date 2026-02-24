<?php

namespace App\Livewire\Accounting\CashBook;

use App\Models\CashBookEntry;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $source = '';
    public $startDate;
    public $endDate;
    public $sortBy = 'date';
    public $sortDirection = 'desc';
    public $aiInsights = null;

    public function generateInsights(\App\Services\AiService $aiService)
    {
        $businessId = Auth::user()->business_id;
        $entries = CashBookEntry::where('business_id', $businessId)
            ->with('category')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        if ($entries->isEmpty()) {
            session()->flash('error', __('Not enough data for AI insights.'));
            return;
        }

        $promptBase = \App\Models\Setting::get('ai.business_insights_prompt', 'Analyze the following cash book entries and provide a brief summary of cash flow health, highlighting any potential areas for cost savings.');

        $data = $entries->map(function ($entry) {
            return "- {$entry->date->format('Y-m-d')}: {$entry->type} of {$entry->amount} for {$entry->description} (Category: " . ($entry->category->name ?? 'General') . ")";
        })->implode("\n");

        $prompt = $promptBase . "\n\nData:\n" . $data;

        try {
            $this->aiInsights = $aiService->generateText($prompt);
        } catch (\Exception $e) {
            session()->flash('error', __('AI Generation failed: ') . $e->getMessage());
        }
    }

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function render()
    {
        $businessId = Auth::user()->business_id;
        $query = CashBookEntry::where('business_id', $businessId)
            ->with(['category', 'invoice', 'expense']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('booking_number', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->source) {
            $query->where('source', $this->source);
        }

        if ($this->startDate) {
            $query->where('date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->where('date', '<=', $this->endDate);
        }

        $entries = $query->orderBy($this->sortBy, $this->sortDirection)->paginate(20);

        // Totals based on current filters (ignoring 'type' filter so we can show both income/expense cards)
        $totalsQuery = CashBookEntry::where('business_id', $businessId);

        if ($this->search) {
            $totalsQuery->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('booking_number', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->source) {
            $totalsQuery->where('source', $this->source);
        }
        if ($this->startDate) {
            $totalsQuery->where('date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $totalsQuery->where('date', '<=', $this->endDate);
        }

        $incomeTotal = (clone $totalsQuery)->where('type', 'income')->sum('amount');
        $expenseTotal = (clone $totalsQuery)->where('type', 'expense')->sum('amount');

        return view('livewire.accounting.cash-book.index', [
            'entries' => $entries,
            'incomeTotal' => $incomeTotal,
            'expenseTotal' => $expenseTotal,
            'balance' => $incomeTotal - $expenseTotal,
        ]);
    }

    public function delete($id)
    {
        $businessId = Auth::user()->business_id;
        $entry = CashBookEntry::where('business_id', $businessId)->findOrFail($id);

        if ($entry->expense) {
            $entry->expense->delete();
        }

        $entry->delete();

        session()->flash('message', __('Entry and associated expense deleted successfully.'));
    }
}
