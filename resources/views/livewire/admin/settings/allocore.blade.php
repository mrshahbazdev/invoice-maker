<div class="max-w-4xl mx-auto">
    <div class="adm-head">
        <div>
            <h2 class="adm-title">{{ __('Allocore Integration') }}</h2>
            <p class="adm-sub">{{ __('Manage API keys and settings for the Allocore Tools Platform integration.') }}</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="adm-flash is-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="adm-flash is-error">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Linked Business Section --}}
    <div class="adm-card mb-6">
        <div class="adm-card-head">
            <div class="flex items-center gap-3">
                <div class="adm-stat-icon" style="background: rgba(255, 140, 0, .12); color: #ffb454; width: 40px; height: 40px;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h3>{{ __('Linked Business / Company') }}</h3>
                    <p>{{ __('Select an existing business account to receive Allocore invoices. If none selected, a new Allocore business will be auto-created.') }}</p>
                </div>
            </div>
        </div>

        <form wire:submit="save" class="adm-card-body space-y-4">
            <div>
                <label class="adm-label">{{ __('Attach to Business') }}</label>
                <select wire:model="allocore_linked_business_id" class="adm-input">
                    <option value="">{{ __('-- Auto-create new Allocore business --') }}</option>
                    @foreach($businesses as $biz)
                        <option value="{{ $biz['id'] }}">{{ $biz['name'] }} ({{ $biz['email'] }})</option>
                    @endforeach
                </select>
                <p class="adm-hint">{{ __('All Allocore-generated invoices will appear under this business account. Clients from Allocore will be added as clients of this business.') }}</p>
                @error('allocore_linked_business_id') <span class="adm-error">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled" class="adm-btn adm-btn-primary">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>

    {{-- API Key Section --}}
    <div class="adm-card mb-6">
        <div class="adm-card-head">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="adm-stat-icon" style="background: rgba(168, 85, 247, .12); color: #d8b4fe; width: 40px; height: 40px;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3>{{ __('API Authentication') }}</h3>
                        <p>{{ __('API key for Allocore ↔ Invoice Maker communication') }}</p>
                    </div>
                </div>
                @if(!empty($allocore_api_key))
                    <span class="adm-badge is-green">{{ __('Configured') }}</span>
                @else
                    <span class="adm-badge is-yellow">{{ __('Not Configured') }}</span>
                @endif
            </div>
        </div>

        <form wire:submit="save" class="adm-card-body space-y-6">
            <div>
                <label class="adm-label">{{ __('API Key') }}</label>
                <input type="password" wire:model="allocore_api_key" class="adm-input mono"
                    placeholder="alc_xxxxxxxxxxxx...">
                <p class="adm-hint">{{ __('Must match the INVOICE_MAKER_API_KEY configured in Allocore') }}</p>
                @error('allocore_api_key') <span class="adm-error">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="adm-label">{{ __('Webhook URL (Allocore)') }}</label>
                <input type="url" wire:model="allocore_webhook_url" class="adm-input"
                    placeholder="https://allocore.example.com/api/webhooks/invoice-status">
                <p class="adm-hint">{{ __('Allocore webhook endpoint to receive invoice status updates') }}</p>
                @error('allocore_webhook_url') <span class="adm-error">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2 flex-wrap">
                <button type="submit" wire:loading.attr="disabled" class="adm-btn adm-btn-primary">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Save') }}
                </button>
                <button type="button" wire:click="generateKey" wire:loading.attr="disabled"
                    onclick="return confirm('Generate a new API key? The old key will be overwritten!')"
                    class="adm-btn adm-btn-purple">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    {{ __('Generate New Key') }}
                </button>
                <button type="button" wire:click="testConnection" wire:loading.attr="disabled" class="adm-btn adm-btn-secondary">
                    {{ __('Test') }}
                </button>
            </div>
        </form>
    </div>

    {{-- Business & Invoice Settings --}}
    <div class="adm-card mb-6">
        <div class="adm-card-head">
            <div class="flex items-center gap-3">
                <div class="adm-stat-icon" style="background: rgba(59, 130, 246, .12); color: #93c5fd; width: 40px; height: 40px;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3>{{ __('Allocore Business & Invoice Defaults') }}</h3>
                    <p>{{ __('Default values for invoices created from Allocore orders') }}</p>
                </div>
            </div>
        </div>

        <form wire:submit="save" class="adm-card-body space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="adm-label">{{ __('Business Name') }}</label>
                    <input type="text" wire:model="allocore_business_name" class="adm-input"
                        placeholder="Allocore GmbH">
                    @error('allocore_business_name') <span class="adm-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="adm-label">{{ __('Business Email') }}</label>
                    <input type="email" wire:model="allocore_business_email" class="adm-input"
                        placeholder="billing@allocore.com">
                    @error('allocore_business_email') <span class="adm-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="adm-label">{{ __('Invoice Prefix') }}</label>
                    <input type="text" wire:model="allocore_invoice_prefix" class="adm-input" placeholder="ALC">
                    @error('allocore_invoice_prefix') <span class="adm-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="adm-label">{{ __('Default Tax Rate (%)') }}</label>
                    <input type="number" wire:model="allocore_default_tax_rate" step="0.01" min="0" max="100"
                        class="adm-input" placeholder="19">
                    @error('allocore_default_tax_rate') <span class="adm-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="adm-label">{{ __('Payment Terms (Days)') }}</label>
                    <input type="number" wire:model="allocore_payment_terms_days" min="0" max="365"
                        class="adm-input" placeholder="14">
                    @error('allocore_payment_terms_days') <span class="adm-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4" style="border-top: 1px solid var(--adm-border);">
                <button type="submit" wire:loading.attr="disabled" class="adm-btn adm-btn-primary">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>
    </div>

    {{-- Info Section --}}
    <div class="adm-card">
        <div class="adm-card-body">
            <h4 class="text-sm font-semibold text-white mb-3">{{ __('Setup Guide') }}</h4>
            <ul class="space-y-2 text-sm text-gray-300">
                <li class="flex items-start gap-2">
                    <span class="text-brand-400 font-bold mt-0.5">1.</span>
                    {{ __('Generate an API key here or enter the one from Allocore admin panel.') }}
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-brand-400 font-bold mt-0.5">2.</span>
                    {{ __('Copy the same key to Allocore → Admin → Settings → Invoice Maker → API-Key.') }}
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-brand-400 font-bold mt-0.5">3.</span>
                    {{ __('Set the Invoice Maker Base-URL in Allocore settings (e.g. https://invoice.example.com).') }}
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-brand-400 font-bold mt-0.5">4.</span>
                    {{ __('Optionally configure webhook URL so Invoice Maker can notify Allocore of status changes.') }}
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-gray-600 mt-0.5">•</span>
                    {{ __('API keys are stored encrypted in the database. Admin panel settings override .env values.') }}
                </li>
            </ul>
        </div>
    </div>
</div>
