<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Business;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class Allocore extends Component
{
    public $allocore_api_key;
    public $allocore_webhook_url;
    public $allocore_linked_business_id;
    public $allocore_business_name;
    public $allocore_business_email;
    public $allocore_invoice_prefix;
    public $allocore_default_tax_rate;
    public $allocore_payment_terms_days;
    public $businesses = [];

    public function mount()
    {
        $this->businesses = Business::select('id', 'name', 'email')->orderBy('name')->get()->toArray();
        $this->allocore_api_key = Setting::get('allocore.api_key');
        $this->allocore_webhook_url = Setting::get('allocore.webhook_url');
        $this->allocore_linked_business_id = Setting::get('allocore.linked_business_id');
        $this->allocore_business_name = Setting::get('allocore.business_name', 'Allocore GmbH');
        $this->allocore_business_email = Setting::get('allocore.business_email', 'billing@allocore.com');
        $this->allocore_invoice_prefix = Setting::get('allocore.invoice_prefix', 'ALC');
        $this->allocore_default_tax_rate = Setting::get('allocore.default_tax_rate', '19');
        $this->allocore_payment_terms_days = Setting::get('allocore.payment_terms_days', '14');
    }

    public function save()
    {
        $this->validate([
            'allocore_api_key' => 'nullable|string|max:255',
            'allocore_webhook_url' => 'nullable|url|max:255',
            'allocore_linked_business_id' => 'nullable|integer|exists:businesses,id',
            'allocore_business_name' => 'nullable|string|max:255',
            'allocore_business_email' => 'nullable|email|max:255',
            'allocore_invoice_prefix' => 'nullable|string|max:10',
            'allocore_default_tax_rate' => 'nullable|numeric|min:0|max:100',
            'allocore_payment_terms_days' => 'nullable|integer|min:0|max:365',
        ]);

        Setting::set('allocore.api_key', $this->allocore_api_key);
        Setting::set('allocore.webhook_url', $this->allocore_webhook_url);
        Setting::set('allocore.linked_business_id', $this->allocore_linked_business_id);
        Setting::set('allocore.business_name', $this->allocore_business_name);
        Setting::set('allocore.business_email', $this->allocore_business_email);
        Setting::set('allocore.invoice_prefix', $this->allocore_invoice_prefix);
        Setting::set('allocore.default_tax_rate', $this->allocore_default_tax_rate);
        Setting::set('allocore.payment_terms_days', $this->allocore_payment_terms_days);

        session()->flash('message', 'Allocore-Integration erfolgreich gespeichert.');
    }

    public function generateKey()
    {
        $this->allocore_api_key = 'alc_' . bin2hex(random_bytes(32));
        Setting::set('allocore.api_key', $this->allocore_api_key);

        session()->flash('message', 'Neuer API-Key generiert: ' . $this->allocore_api_key . ' — Bitte diesen Key auch im Allocore als INVOICE_MAKER_API_KEY eintragen!');
    }

    public function testConnection()
    {
        if (empty($this->allocore_api_key)) {
            session()->flash('error', 'Kein API-Key konfiguriert. Bitte zuerst einen API-Key eingeben oder generieren.');
            return;
        }

        session()->flash('message', 'API-Key ist konfiguriert und bereit. Die Verbindung wird beim nächsten Allocore-Aufruf geprüft.');
    }

    public function render()
    {
        return view('livewire.admin.settings.allocore')
            ->layout('layouts.admin', ['title' => 'Allocore Integration']);
    }
}
