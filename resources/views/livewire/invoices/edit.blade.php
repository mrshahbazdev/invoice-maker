@php $title = __('Edit Invoice'); @endphp

<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Edit Invoice') }}</h2>
            <p class="text-gray-600">{{ $invoice->invoice_number }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Client') }} *</label>
                <select wire:model="client_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @foreach($this->clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} @if($client->company_name)
                        ({{ $client->company_name }}) @endif</option>
                    @endforeach
                </select>
                @error('client_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Currency Override') }}</label>
                <select wire:model="currency"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="USD">USD - {{ __('US Dollar') }}</option>
                    <option value="EUR">EUR - {{ __('Euro') }}</option>
                    <option value="GBP">GBP - {{ __('British Pound') }}</option>
                    <option value="CAD">CAD - {{ __('Canadian Dollar') }}</option>
                    <option value="AUD">AUD - {{ __('Australian Dollar') }}</option>
                    <option value="JPY">JPY - {{ __('Japanese Yen') }}</option>
                    <option value="PKR">PKR - {{ __('Pakistani Rupee') }}</option>
                    <option value="INR">INR - {{ __('Indian Rupee') }}</option>
                    <option value="AED">AED - {{ __('UAE Dirham') }}</option>
                </select>
                @error('currency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Invoice Date') }} *</label>
                <input type="date" wire:model="invoice_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('invoice_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Due Date') }} *</label>
                <input type="date" wire:model="due_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('due_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes') }}</label>
            <textarea wire:model="notes" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-sm font-semibold text-gray-900">{{ __('Recurring Invoice') }}</h4>
                    <p class="text-xs text-gray-500">{{ __('Automatically generate this invoice on a schedule') }}</p>
                </div>
                <button type="button" wire:click="$set('is_recurring', {{ !$is_recurring ? 'true' : 'false' }})"
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 {{ $is_recurring ? 'bg-blue-600' : 'bg-gray-200' }}">
                    <span
                        class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $is_recurring ? 'translate-x-5' : 'translate-x-0' }}"></span>
                </button>
            </div>

            @if($is_recurring)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-transition>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Frequency') }}</label>
                        <select wire:model="recurring_frequency"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="weekly">{{ __('Weekly') }}</option>
                            <option value="monthly">{{ __('Monthly') }}</option>
                            <option value="quarterly">{{ __('Quarterly') }}</option>
                            <option value="yearly">{{ __('Yearly') }}</option>
                        </select>
                        @error('recurring_frequency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg self-end">
                        <p class="text-xs text-blue-700 font-medium">
                            <svg class="w-4 h-4 inline mr-1 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('Next Generation') }}:
                            {{ $invoice->next_run_date ? $invoice->next_run_date->format('M d, Y') : __('Today') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Items') }}</h3>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search Products') }}</label>
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="product_search"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('Type to search products...') }}">
                @if($this->products->count() > 0)
                    <div
                        class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                        @foreach($this->products as $product)
                            <button wire:click="selectProduct({{ $product->id }})"
                                class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                <div class="font-medium">{{ $product->name }}</div>
                                <div class="text-sm text-gray-500 flex justify-between items-center">
                                    <span>{{ $this->currency_symbol }}{{ number_format((float) $product->price, 2) }} /
                                        {{ __($product->unit) }}</span>
                                    @if($product->manage_stock)
                                        <span
                                            class="text-xs font-semibold {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->stock_quantity }} {{ __('in stock') }}
                                        </span>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-4 mb-4">
            @forelse($items as $index => $item)
                <div class="p-4 border rounded-lg bg-gray-50">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-sm font-medium">{{ __('Item') }} {{ $index + 1 }}</span>
                        <button wire:click="removeItem({{ $index }})"
                            class="text-red-600 hover:text-red-700 text-sm">{{ __('Remove') }}</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }} *</label>
                            <textarea wire:model="items.{{ $index }}.description" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Quantity') }} *</label>
                            <input type="number" step="0.01" wire:model.live="items.{{ $index }}.quantity"
                                wire:change="updateItemTotal({{ $index }})"
                                class="w-full px-3 py-2 border {{ (isset($item['manage_stock']) && $item['manage_stock'] && $item['quantity'] > ($item['stock_quantity'] ?? 0)) ? 'border-red-500 bg-red-50 text-red-900 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' }} rounded-lg text-sm">
                            @if(isset($item['manage_stock']) && $item['manage_stock'])
                                <p
                                    class="mt-1 text-xs {{ $item['quantity'] > ($item['stock_quantity'] ?? 0) ? 'text-red-700 font-bold' : 'text-gray-500' }}">
                                    {{ __('Current Stock') }}: {{ $item['stock_quantity'] ?? 0 }}
                                </p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Unit Price') }} *</label>
                            <input type="number" step="0.01" wire:model.live="items.{{ $index }}.unit_price"
                                wire:change="updateItemTotal({{ $index }})"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Tax Rate') }} (%)</label>
                            <input type="number" step="0.01" wire:model.live="items.{{ $index }}.tax_rate"
                                wire:change="updateItemTotal({{ $index }})"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Total') }}</label>
                            <div class="px-3 py-2 bg-gray-100 rounded-lg text-sm font-medium">
                                {{ $this->currency_symbol }}{{ number_format((float) $item['total'], 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    {{ __('No items. Click "Add Item" to start.') }}
                </div>
            @endforelse
        </div>

        <button wire:click="addItem" type="button"
            class="w-full border-2 border-dashed border-gray-300 rounded-lg py-3 text-gray-600 hover:border-blue-500 hover:text-blue-600 transition">
            + {{ __('Add Item') }}
        </button>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Summary') }}</h3>

        <div class="space-y-2">
            <div class="flex justify-between">
                <span>{{ __('Subtotal') }}:</span>
                <span>{{ $this->currency_symbol }}{{ number_format((float) $this->totals['subtotal'], 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>{{ __('Tax') }}:</span>
                <span>{{ $this->currency_symbol }}{{ number_format((float) $this->totals['tax_total'], 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-lg pt-2 border-t">
                <span>{{ __('Total') }}:</span>
                <span>{{ auth()->user()->business->currency_symbol }}{{ number_format((float) $this->totals['grand_total'], 2) }}</span>
            </div>
        </div>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('invoices.show', $invoice) }}"
            class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            {{ __('Cancel') }}
        </a>
        <button wire:click="save" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            {{ __('Update Invoice') }}
        </button>
    </div>
</div>