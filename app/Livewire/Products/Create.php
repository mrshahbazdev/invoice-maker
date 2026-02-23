<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public string $name = '';
    public string $description = '';
    public string $price = '';
    public string $purchase_price = '';
    public string $unit = 'unit';
    public string $tax_rate = '0';
    public int $stock_quantity = 0;
    public bool $manage_stock = false;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'purchase_price' => 'nullable|numeric|min:0',
        'unit' => 'required|string|max:50',
        'tax_rate' => 'required|numeric|min:0|max:100',
        'stock_quantity' => 'required_if:manage_stock,true|integer|min:0',
        'manage_stock' => 'boolean',
    ];

    public function save(): void
    {
        $this->validate();

        Auth::user()->business->products()->create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'purchase_price' => $this->purchase_price ?: 0,
            'unit' => $this->unit,
            'tax_rate' => $this->tax_rate,
            'stock_quantity' => $this->manage_stock ? $this->stock_quantity : 0,
            'manage_stock' => $this->manage_stock,
        ]);

        session()->flash('message', 'Product created successfully.');
        $this->redirect(route('products.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.products.create');
    }
}
