<?php

namespace App\Livewire\Admin\Businesses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Business;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setPlan($businessId, $planName)
    {
        $business = Business::findOrFail($businessId);
        $business->plan = $planName;
        $business->save();

        // Removed notification dispatch, simple update
    }

    public function render()
    {
        $businesses = Business::with('user')
            ->withCount('invoices')
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.businesses.index', compact('businesses'))
            ->layout('layouts.admin', ['title' => 'Business Management']);
    }
}
