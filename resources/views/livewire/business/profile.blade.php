@php $title = __('Business Profile'); @endphp

<div>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">{{ __('Business Profile') }}</h2>
        <p class="text-gray-600">{{ __('Manage your business information') }}</p>
    </div>

    <div class="max-w-2xl">
        <form wire:submit="save" class="bg-white rounded-lg shadow p-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Business Name') }}</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('Your Business Name') }}">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
                <input type="email" wire:model="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('business@example.com') }}">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Phone') }}</label>
                <input type="text" wire:model="phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('+1 (555) 123-4567') }}">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6" wire:ignore>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Address') }}</label>
                <textarea wire:model="address" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('123 Business Street') }}&#10;{{ __('City, State ZIP') }}"></textarea>
                @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Tax Number / VAT / GST') }}</label>
                <input type="text" wire:model="tax_number"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('e.g. US123456789') }}">
                @error('tax_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label
                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('Bank Details (Shown on Invoices)') }}</label>
                <textarea wire:model="bank_details" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('Bank Name: Example Bank') }}&#10;{{ __('Account No: 123456789') }}&#10;{{ __('Routing/Swift: EXMPUS33') }}"></textarea>
                @error('bank_details') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label
                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('Default Payment Terms & Instructions') }}</label>
                <textarea wire:model="payment_terms" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('e.g. Please initiate wire transfer immediately.') }}"></textarea>
                @error('payment_terms') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Currency') }}</label>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Language') }}</label>
                <select wire:model="language"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="en">English</option>
                    <option value="de">German (Deutsch)</option>
                    <option value="es">Spanish (Español)</option>
                    <option value="fr">French (Français)</option>
                    <option value="it">Italian (Italiano)</option>
                    <option value="pt">Portuguese (Português)</option>
                    <option value="ar">Arabic (العربية)</option>
                    <option value="zh">Chinese (中文)</option>
                    <option value="ja">Japanese (日本語)</option>
                    <option value="ru">Russian (Русский)</option>
                </select>
                @error('language') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Timezone') }}</label>
                <select wire:model="timezone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="UTC">UTC</option>
                    <option value="America/New_York">America/New_York</option>
                    <option value="America/Los_Angeles">America/Los_Angeles</option>
                    <option value="America/Chicago">America/Chicago</option>
                    <option value="Europe/London">Europe/London</option>
                    <option value="Europe/Paris">Europe/Paris</option>
                    <option value="Asia/Tokyo">Asia/Tokyo</option>
                    <option value="Asia/Singapore">Asia/Singapore</option>
                    <option value="Australia/Sydney">Australia/Sydney</option>
                </select>
                @error('timezone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label
                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('Invoice Number Prefix') }}</label>
                    <input type="text" wire:model="invoice_number_prefix"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. INV">
                    @error('invoice_number_prefix') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Next Invoice Number') }}</label>
                    <input type="number" wire:model="invoice_number_next"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="1">
                    @error('invoice_number_next') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    <p class="mt-1 text-xs text-gray-500">{{ __('The sequence will continue from this number.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Bank Booking Account') }}</label>
                    <input type="text" wire:model="bank_booking_account"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. 1200">
                    @error('bank_booking_account') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Cash Booking Account') }}</label>
                    <input type="text" wire:model="cash_booking_account"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. 1000">
                    @error('cash_booking_account') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Logo') }}</label>
                @if($business && $business->logo)
                    <div class="mb-4 flex items-center gap-4">
                        <img src="{{ asset('storage/' . $business->logo) }}" alt="Logo" class="h-16 w-auto">
                        <button type="button" wire:click="removeLogo"
                            class="text-red-600 hover:text-red-700 text-sm">{{ __('Remove') }}</button>
                    </div>
                @endif
                <input type="file" wire:model="logo"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8 border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Email Settings (Optional SMTP)') }}</h3>
                <p class="text-sm text-gray-500 mb-6">
                    {{ __('Configure your own SMTP server to send emails from your own domain. If left empty, the system default will be used.') }}
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('SMTP Host') }}</label>
                        <input type="text" wire:model="smtp_host"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="smtp.example.com">
                        @error('smtp_host') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('SMTP Port') }}</label>
                        <input type="number" wire:model="smtp_port"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="587">
                        @error('smtp_port') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('SMTP Username') }}</label>
                        <input type="text" wire:model="smtp_username"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('smtp_username') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('SMTP Password') }}</label>
                        <input type="password" wire:model="smtp_password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('smtp_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Encryption') }}</label>
                    <select wire:model="smtp_encryption"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">{{ __('None') }}</option>
                        <option value="tls">TLS</option>
                        <option value="ssl">SSL</option>
                    </select>
                    @error('smtp_encryption') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('From Email') }}</label>
                        <input type="email" wire:model="smtp_from_address"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="info@yourcompany.com">
                        @error('smtp_from_address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('From Name') }}</label>
                        <input type="text" wire:model="smtp_from_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Your Company Name">
                        @error('smtp_from_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="button" wire:click="testSmtpConnection" wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg wire:loading wire:target="testSmtpConnection"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ __('Test Connection') }}
                    </button>
                    <span wire:loading wire:target="testSmtpConnection" class="text-sm text-blue-600 font-medium">
                        {{ __('Testing...') }}
                    </span>
                </div>
            </div>

            <div class="mb-8 border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Online Payments') }}</h3>
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-base font-medium text-gray-900">{{ __('Stripe Integration') }}</h4>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ __('Accept credit cards, Apple Pay, and Google Pay directly on your invoices.') }}
                            </p>
                        </div>
                        @if(!$business)
                            <p class="text-sm text-gray-400 italic">
                                {{ __('Create your business profile first to connect Stripe.') }}
                            </p>
                        @elseif($stripe_onboarding_complete)
                            <div class="flex items-center gap-2">
                                <span
                                    class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('Connected') }}
                                </span>
                            </div>
                        @else
                            <button type="button" wire:click="connectStripe"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.976 9.15c-2.172-.806-3.356-1.143-3.356-2.076 0-.776.78-1.42 2.308-1.42 1.34 0 2.872.54 4.02 1.258l1.325-3.56A10.824 10.824 0 0012.784 2c-3.792 0-6.19 1.947-6.19 4.796 0 3.737 4.197 4.547 5.926 5.093 2.14.678 3.12 1.256 3.12 2.238 0 .86-.88 1.488-2.617 1.488-1.503 0-3.32-.61-4.706-1.487l-1.393 3.61c1.472.8 3.518 1.257 5.564 1.257 3.96 0 6.33-1.928 6.33-4.887 0-3.5-3.615-4.14-5.842-5.02z" />
                                </svg>
                                {{ __('Connect with Stripe') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                    {{ $business ? __('Save Changes') : __('Create Business Profile') }}
                </button>
            </div>
        </form>
    </div>
</div>