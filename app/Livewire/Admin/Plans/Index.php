<?php

namespace App\Livewire\Admin\Plans;

use App\Models\Plan;
use Livewire\Component;

class Index extends Component
{
 public $plans;

 public $editingPlan = null;
 public $name, $slug, $price_monthly, $price_yearly, $currency;
 public $max_invoices, $max_clients, $max_products, $is_active;

 #[\Livewire\Attributes\Layout('layouts.admin', ['title' => 'Subscription Plans'])]
 public function render()
 {
 $this->plans = Plan::orderBy('price_monthly', 'asc')->get();
 return view('livewire.admin.plans.index');
 }

 public function mount()
 {
 // Seed some defaults if empty
 if (Plan::count() === 0) {
 Plan::create([
 'name' => 'Essential',
 'slug' => 'essential',
 'price_monthly' => 9.99,
 'price_yearly' => 99.90,
 'max_invoices' => 50,
 'max_clients' => 50,
 'max_products' => 50,
 'is_active' => true,
 'currency' => 'USD'
 ]);
 Plan::create([
 'name' => 'Professional',
 'slug' => 'professional',
 'price_monthly' => 19.99,
 'price_yearly' => 199.90,
 'max_invoices' => null,
 'max_clients' => null,
 'max_products' => null,
 'is_active' => true,
 'currency' => 'USD'
 ]);
 }
 }

 public function editPlan($id)
 {
 $plan = Plan::findOrFail($id);
 $this->editingPlan = $plan->id;

 $this->name = $plan->name;
 $this->slug = $plan->slug;
 $this->price_monthly = $plan->price_monthly;
 $this->price_yearly = $plan->price_yearly;
 $this->currency = $plan->currency;
 $this->max_invoices = $plan->max_invoices;
 $this->max_clients = $plan->max_clients;
 $this->max_products = $plan->max_products;
 $this->is_active = $plan->is_active;
 }

 public function savePlan()
 {
 $this->validate([
 'name' => 'required|string|max:255',
 'slug' => 'required|string|max:255|unique:plans,slug,' . ($this->editingPlan === 'new' ? 'NULL' : $this->editingPlan),
 'price_monthly' => 'required|numeric|min:0',
 'price_yearly' => 'required|numeric|min:0',
 'currency' => 'required|string|max:10',
 'max_invoices' => 'nullable|integer|min:1',
 'max_clients' => 'nullable|integer|min:1',
 'max_products' => 'nullable|integer|min:1',
 'is_active' => 'boolean',
 ]);

 if ($this->editingPlan && $this->editingPlan !== 'new') {
 $plan = Plan::find($this->editingPlan);
 $plan->update([
 'name' => $this->name,
 'slug' => $this->slug,
 'price_monthly' => $this->price_monthly,
 'price_yearly' => $this->price_yearly,
 'currency' => $this->currency,
 'max_invoices' => $this->max_invoices === '' ? null : $this->max_invoices,
 'max_clients' => $this->max_clients === '' ? null : $this->max_clients,
 'max_products' => $this->max_products === '' ? null : $this->max_products,
 'is_active' => $this->is_active,
 ]);

 session()->flash('message', 'Plan updated successfully.');
 } else {
 Plan::create([
 'name' => $this->name,
 'slug' => $this->slug,
 'price_monthly' => $this->price_monthly,
 'price_yearly' => $this->price_yearly,
 'currency' => $this->currency,
 'max_invoices' => $this->max_invoices === '' ? null : $this->max_invoices,
 'max_clients' => $this->max_clients === '' ? null : $this->max_clients,
 'max_products' => $this->max_products === '' ? null : $this->max_products,
 'is_active' => $this->is_active,
 ]);
 session()->flash('message', 'Plan created successfully.');
 }

 $this->cancelEdit();
 }

 public function createPlan()
 {
 $this->cancelEdit();
 $this->editingPlan = 'new';
 $this->currency = 'USD';
 $this->is_active = true;
 }

 public function cancelEdit()
 {
 $this->reset(['editingPlan', 'name', 'slug', 'price_monthly', 'price_yearly', 'currency', 'max_invoices', 'max_clients', 'max_products', 'is_active']);
 }
}
