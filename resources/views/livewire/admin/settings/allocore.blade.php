<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold font-heading text-white">{{ __('Allocore Integration') }}</h2>
        <p class="text-gray-400 mt-1">{{ __('Manage API keys and settings for the Allocore Tools Platform integration.') }}</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Linked Business Section --}}
    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-6 sm:p-8 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">{{ __('Linked Business / Company') }}</h3>
                <p class="text-sm text-gray-500">{{ __('Select an existing business account to receive Allocore invoices. If none selected, a new Allocore business will be auto-created.') }}</p>
            </div>
        </div>

        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Attach to Business') }}</label>
                <select wire:model="allocore_linked_business_id"
                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3">
                    <option value="">{{ __('-- Auto-create new Allocore business --') }}</option>
                    @foreach($businesses as $biz)
                        <option value="{{ $biz['id'] }}">{{ $biz['name'] }} ({{ $biz['email'] }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">{{ __('All Allocore-generated invoices will appear under this business account. Clients from Allocore will be added as clients of this business.') }}</p>
                @error('allocore_linked_business_id') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-xl font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 focus:ring-offset-gray-900 disabled:opacity-50 transition-colors shadow-lg shadow-brand-500/20">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>

    {{-- API Key Section --}}
    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-6 sm:p-8 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white">{{ __('API Authentication') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('API key for Allocore ↔ Invoice Maker communication') }}</p>
                </div>
            </div>
            @if(!empty($allocore_api_key))
                <span class="px-3 py-1 text-xs font-semibold rounded-lg bg-green-500/10 text-green-400 border border-green-500/20">{{ __('Configured') }}</span>
            @else
                <span class="px-3 py-1 text-xs font-semibold rounded-lg bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">{{ __('Not Configured') }}</span>
            @endif
        </div>

        <form wire:submit="save" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('API Key') }}</label>
                <input type="password" wire:model="allocore_api_key"
                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3"
                    placeholder="alc_xxxxxxxxxxxx...">
                <p class="text-xs text-gray-500 mt-1">{{ __('Must match the INVOICE_MAKER_API_KEY configured in Allocore') }}</p>
                @error('allocore_api_key') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Webhook URL (Allocore)') }}</label>
                <input type="url" wire:model="allocore_webhook_url"
                    class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3"
                    placeholder="https://allocore.example.com/api/webhooks/invoice-status">
                <p class="text-xs text-gray-500 mt-1">{{ __('Allocore webhook endpoint to receive invoice status updates') }}</p>
                @error('allocore_webhook_url') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-xl font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 focus:ring-offset-gray-900 disabled:opacity-50 transition-colors shadow-lg shadow-brand-500/20">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Save') }}
                </button>
                <button type="button" wire:click="generateKey" wire:loading.attr="disabled"
                    onclick="return confirm('Generate a new API key? The old key will be overwritten!')"
                    class="inline-flex items-center px-6 py-3 bg-purple-500/10 border border-purple-500/30 rounded-xl font-semibold text-purple-400 hover:bg-purple-500/20 focus:outline-none disabled:opacity-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    {{ __('Generate New Key') }}
                </button>
                <button type="button" wire:click="testConnection" wire:loading.attr="disabled"
                    class="inline-flex items-center px-6 py-3 bg-gray-700/50 border border-gray-600 rounded-xl font-semibold text-gray-300 hover:bg-gray-700 focus:outline-none disabled:opacity-50 transition-colors">
                    {{ __('Test') }}
                </button>
            </div>
        </form>
    </div>

    {{-- Business & Invoice Settings --}}
    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-6 sm:p-8 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">{{ __('Allocore Business & Invoice Defaults') }}</h3>
                <p class="text-sm text-gray-500">{{ __('Default values for invoices created from Allocore orders') }}</p>
            </div>
        </div>

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Business Name') }}</label>
                    <input type="text" wire:model="allocore_business_name"
                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3"
                        placeholder="Allocore GmbH">
                    @error('allocore_business_name') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Business Email') }}</label>
                    <input type="email" wire:model="allocore_business_email"
                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3"
                        placeholder="billing@allocore.com">
                    @error('allocore_business_email') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Invoice Prefix') }}</label>
                    <input type="text" wire:model="allocore_invoice_prefix"
                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3"
                        placeholder="ALC">
                    @error('allocore_invoice_prefix') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Default Tax Rate (%)') }}</label>
                    <input type="number" wire:model="allocore_default_tax_rate" step="0.01" min="0" max="100"
                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3"
                        placeholder="19">
                    @error('allocore_default_tax_rate') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Payment Terms (Days)') }}</label>
                    <input type="number" wire:model="allocore_payment_terms_days" min="0" max="365"
                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3"
                        placeholder="14">
                    @error('allocore_payment_terms_days') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-700/50">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-xl font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 focus:ring-offset-gray-900 disabled:opacity-50 transition-colors shadow-lg shadow-brand-500/20">
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
    <div class="bg-gray-800/30 border border-gray-700/30 rounded-2xl p-6">
        <h4 class="text-sm font-semibold text-white mb-3">{{ __('Setup Guide') }}</h4>
        <ul class="space-y-2 text-xs text-gray-400">
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
