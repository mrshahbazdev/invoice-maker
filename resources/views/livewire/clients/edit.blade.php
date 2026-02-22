@php $title = __('Edit Client'); @endphp

<div>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">{{ __('Edit Client') }}</h2>
        <p class="text-gray-600">{{ __('Update client information') }}</p>
    </div>

    <div class="max-w-2xl">
        <form wire:submit="save" class="bg-white rounded-lg shadow p-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Contact Name') }} *</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
                <input type="email" wire:model="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Phone') }}</label>
                <input type="text" wire:model="phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Company Name') }}</label>
                <input type="text" wire:model="company_name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('company_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Address') }}</label>
                <textarea wire:model="address" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Tax Number') }}</label>
                <input type="text" wire:model="tax_number"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('tax_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Currency Override') }}</label>
                <select wire:model="currency"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="USD">{{ __('USD - US Dollar') }}</option>
                    <option value="EUR">{{ __('EUR - Euro') }}</option>
                    <option value="GBP">{{ __('GBP - British Pound') }}</option>
                    <option value="CAD">{{ __('CAD - Canadian Dollar') }}</option>
                    <option value="AUD">{{ __('AUD - Australian Dollar') }}</option>
                    <option value="JPY">{{ __('JPY - Japanese Yen') }}</option>
                    <option value="PKR">{{ __('PKR - Pakistani Rupee') }}</option>
                    <option value="INR">{{ __('INR - Indian Rupee') }}</option>
                    <option value="AED">{{ __('AED - UAE Dirham') }}</option>
                </select>
                @error('currency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Language Preference') }}</label>
                <select wire:model="language"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="en">{{ __('English') }}</option>
                    <option value="es">{{ __('Spanish') }} (Español)</option>
                    <option value="fr">{{ __('French') }} (Français)</option>
                    <option value="de">{{ __('German') }} (Deutsch)</option>
                    <option value="it">{{ __('Italian') }} (Italiano)</option>
                    <option value="pt">{{ __('Portuguese') }} (Português)</option>
                    <option value="ar">{{ __('Arabic') }} (العربية)</option>
                    <option value="zh">{{ __('Chinese') }} (中文)</option>
                    <option value="ja">{{ __('Japanese') }} (日本語)</option>
                    <option value="ru">{{ __('Russian') }} (Русский)</option>
                </select>
                @error('language') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                <p class="mt-2 text-xs text-gray-500">
                    {{ __('This language will be used for PDFs and portal experiences.') }}</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes') }}</label>
                <textarea wire:model="notes" rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('clients.index') }}"
                    class="text-gray-600 hover:text-gray-700 py-2 px-4 rounded-lg border border-gray-300">{{ __('Cancel') }}</a>
                <button type="submit"
                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                    {{ __('Update Client') }}
                </button>
            </div>
        </form>
    </div>
</div>