<?php namespace App\Livewire\Products; use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Auth; class Index extends Component
{ use WithPagination; public string $search = ''; public string $sortBy = 'name'; public string $sortDirection = 'asc'; public function sortBy(string $field): void { if ($this->sortBy === $field) { $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'; } else { $this->sortBy = $field; $this->sortDirection = 'asc'; } } public function delete(int $id): void { $product = Auth::user()->business->products()->findOrFail($id); $product->delete(); session()->flash('message', 'Product deleted successfully.'); } public function render() { $products = Auth::user()->business->products() ->when($this->search, function ($query) { $query->where(function ($q) { $q->where('name', 'like', '%' . $this->search . '%') ->orWhere('description', 'like', '%' . $this->search . '%'); }); }) ->orderBy($this->sortBy, $this->sortDirection) ->paginate(10); return view('livewire.products.index', compact('products')); }
}
