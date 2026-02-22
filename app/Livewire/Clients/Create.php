<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $company_name = '';
    public string $address = '';
    public string $tax_number = '';
    public string $notes = '';
    public string $currency = '';
    public string $language = 'en';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'tax_number' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'currency' => 'nullable|string|max:3',
        'language' => 'required|string|in:en,es,fr,de',
    ];

    public function mount(): void
    {
        $this->currency = Auth::user()->business->currency;
    }

    public function save(): void
    {
        $this->validate();

        Auth::user()->business->clients()->create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'tax_number' => $this->tax_number,
            'notes' => $this->notes,
            'currency' => $this->currency,
            'language' => $this->language,
        ]);

        session()->flash('message', 'Client created successfully.');
        $this->redirect(route('clients.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.clients.create');
    }
}
