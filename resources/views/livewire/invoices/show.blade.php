@php $title = $invoice->isEstimate() ? __('View Estimate') : __('View Invoice'); @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }}
                {{ __('Details') }}</h2>
            <p class="text-gray-600">{{ $invoice->invoice_number }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @if($invoice->status === 'draft')
                <button wire:click="markAsSent" wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50">
                    <svg wire:loading wire:target="markAsSent" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>{{ __('Mark as Sent') }}</span>
                </button>
            @endif
            @if(in_array($invoice->status, ['sent', 'overdue']))
                <button wire:click="openPaidModal" wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50">
                    <svg wire:loading wire:target="openPaidModal" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>{{ __('Mark as Paid') }}</span>
                </button>
            @endif
            @if($invoice->status === 'sent' && $invoice->due_date->isPast())
                <button wire:click="markAsOverdue" wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition disabled:opacity-50">
                    <svg wire:loading wire:target="markAsOverdue" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>{{ __('Mark as Overdue') }}</span>
                </button>
            @endif
            @if(in_array($invoice->status, ['draft', 'sent', 'overdue']))
                <button wire:click="cancelInvoice" wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition disabled:opacity-50">
                    <svg wire:loading wire:target="cancelInvoice" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>{{ __('Cancel') }}</span>
                </button>
            @endif
            <a href="{{ route('invoices.download', $invoice) }}"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                {{ __('Download PDF') }}
            </a>
            <button wire:click="sendEmail" wire:loading.attr="disabled"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center disabled:opacity-50">
                <svg wire:loading wire:target="sendEmail" class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <div wire:loading.remove wire:target="sendEmail">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <span>{{ __('Email') }} {{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }}</span>
            </button>
            <div x-data="{ copied: false }" class="relative">
                <button
                    @click="navigator.clipboard.writeText('{{ \Illuminate\Support\Facades\URL::signedRoute('invoices.public.show', $invoice->id) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span x-text="copied ? '{{ __('Copied!') }}' : '{{ __('Share Link') }}'"></span>
                </button>
            </div>
            @if($invoice->status === 'draft')
                <a href="{{ $invoice->isEstimate() ? route('estimates.edit', $invoice) : route('invoices.edit', $invoice) }}"
                    class="bg-white text-gray-700 py-2 px-4 rounded-lg border border-gray-300 shadow-sm hover:bg-gray-50 transition duration-200 text-center font-medium">
                    {{ __('Edit') }} {{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }}
                </a>
            @endif
            @if($invoice->isEstimate() && $invoice->status !== 'cancelled')
                <button wire:click="convertToInvoice"
                    wire:confirm="{{ __('Convert this estimate to a standard invoice?') }}" wire:loading.attr="disabled"
                    class="inline-flex items-center bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 shadow-sm transition duration-200 text-center font-medium disabled:opacity-50">
                    <svg wire:loading wire:target="convertToInvoice" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>{{ __('Convert to Invoice') }}</span>
                </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('From') }}</h4>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $invoice->business->name }}</p>
                            @if($invoice->business->email)
                            <p class="text-sm text-gray-600">{{ $invoice->business->email }}</p>@endif
                            @if($invoice->business->phone)
                            <p class="text-sm text-gray-600">{{ $invoice->business->phone }}</p>@endif
                            @if($invoice->business->address)
                                <p class="text-sm text-gray-600 whitespace-pre-line">{{ $invoice->business->address }}</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                            {{ $invoice->isEstimate() ? __('ESTIMATE') : __('INVOICE') }} {{ __('TO') }}</h4>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $invoice->client->name }}</p>
                            @if($invoice->client->company_name)
                            <p class="text-sm text-gray-600">{{ $invoice->client->company_name }}</p>@endif
                            @if($invoice->client->email)
                            <p class="text-sm text-gray-600">{{ $invoice->client->email }}</p>@endif
                            @if($invoice->client->phone)
                            <p class="text-sm text-gray-600">{{ $invoice->client->phone }}</p>@endif
                            @if($invoice->client->address)
                                <p class="text-sm text-gray-600 whitespace-pre-line">{{ $invoice->client->address }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                    {{ $invoice->isEstimate() ? __('ESTIMATE') : __('INVOICE') }} {{ __('INFO') }}</h4>
                <div class="space-y-1">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">{{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }}
                            #:</span>
                        <span class="font-medium text-gray-900">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">{{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }}
                            {{ __('Date') }}:</span>
                        <span class="font-medium text-gray-900">{{ $invoice->invoice_date->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">{{ $invoice->isEstimate() ? __('Expiration') : __('Due') }}
                            {{ __('Date') }}:</span>
                        <span class="font-medium text-gray-900">{{ $invoice->due_date->format('M d, Y') }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 text-sm font-semibold text-gray-700">{{ __('Description') }}
                                </th>
                                <th class="text-right py-3 text-sm font-semibold text-gray-700">{{ __('Qty') }}</th>
                                <th class="text-right py-3 text-sm font-semibold text-gray-700">{{ __('Price') }}</th>
                                <th class="text-right py-3 text-sm font-semibold text-gray-700">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr class="border-b">
                                    <td class="py-3">
                                        <p class="font-medium text-gray-900">{{ $item->description }}</p>
                                        @if($item->tax_rate > 0)
                                        <p class="text-sm text-gray-500">{{ __('Tax') }}: {{ $item->tax_rate }}%</p>@endif
                                    </td>
                                    <td class="py-3 text-right text-gray-600">{{ $item->quantity }}</td>
                                    <td class="py-3 text-right text-gray-600">
                                        {{ $invoice->currency_symbol }}{{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="py-3 text-right text-gray-900 font-medium">
                                        {{ $invoice->currency_symbol }}{{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">{{ __('Subtotal') }}:</span>
                            <span
                                class="font-medium">{{ $invoice->currency_symbol }}{{ number_format($invoice->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">{{ __('Tax') }}:</span>
                            <span
                                class="font-medium">{{ $invoice->currency_symbol }}{{ number_format($invoice->tax_total, 2) }}</span>
                        </div>
                        @if($invoice->discount > 0)
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">{{ __('Discount') }}:</span>
                                <span
                                    class="font-medium text-red-600">-{{ $invoice->currency_symbol }}{{ number_format($invoice->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-2 border-t font-bold text-lg">
                            <span>{{ __('Total') }}:</span>
                            <span>{{ $invoice->currency_symbol }}{{ number_format($invoice->grand_total, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($invoice->notes)
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Notes') }}</h4>
                        <p class="text-gray-600">{{ $invoice->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Status') }}</h3>
                <div class="flex items-center justify-between">
                    <span
                        class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-{{ $invoice->status_color }}-100 text-{{ $invoice->status_color }}-700">
                        {{ __(ucfirst($invoice->status)) }}
                    </span>
                    @if($invoice->last_reminder_sent_at)
                        <span class="text-xs text-gray-500" title="{{ __('Last automated reminder sent') }}">
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ $invoice->last_reminder_sent_at->diffForHumans() }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Payment Summary') }}</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ __('Total') }}:</span>
                        <span
                            class="font-medium">{{ $invoice->currency_symbol }}{{ number_format($invoice->grand_total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ __('Paid') }}:</span>
                        <span
                            class="font-medium text-green-600">{{ $invoice->currency_symbol }}{{ number_format($invoice->amount_paid, 2) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t font-bold">
                        <span>{{ __('Due') }}:</span>
                        <span
                            class="{{ $invoice->amount_due > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $invoice->currency_symbol }}{{ number_format($invoice->amount_due, 2) }}</span>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow p-6 border-l-4 {{ $profit >= 0 ? 'border-green-500' : 'border-red-500' }}">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Job Profitability') }}</h3>
                    <span
                        class="text-xs font-bold px-2 py-1 rounded {{ $profit >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ number_format($margin_percentage, 1) }}% {{ __('Margin') }}
                    </span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ __('Revenue') }}:</span>
                        <span
                            class="font-medium text-gray-900">{{ $invoice->currency_symbol }}{{ number_format($invoice->grand_total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ __('Linked Costs') }}:</span>
                        <span
                            class="font-medium text-red-600">-{{ $invoice->currency_symbol }}{{ number_format($total_expenses, 2) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t font-bold text-base">
                        <span>{{ __('Net Profit') }}:</span>
                        <span
                            class="{{ $profit >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $invoice->currency_symbol }}{{ number_format($profit, 2) }}</span>
                    </div>

                    @if($invoice->expenses->count() > 0)
                        <div class="mt-4 pt-4 border-t">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                {{ __('Linked Expenses') }}</h4>
                            <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                @foreach($invoice->expenses as $expense)
                                    <div
                                        class="flex justify-between items-center text-xs p-2 bg-gray-50 rounded border border-gray-100">
                                        <div class="truncate mr-2">
                                            <p class="font-semibold text-gray-900 truncate">{{ $expense->description }}</p>
                                            <p class="text-gray-500 italic">{{ $expense->date->format('d.m.Y') }}</p>
                                        </div>
                                        <span
                                            class="font-bold text-red-600 whitespace-nowrap">-{{ $invoice->currency_symbol }}{{ number_format($expense->amount, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-4 p-3 bg-gray-50 rounded text-center">
                            <p class="text-xs text-gray-500 italic">{{ __('No expenses linked to this invoice yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($invoice->amount_due > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Record Payment') }}</h3>
                    <form wire:submit="recordPayment">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Amount') }}</label>
                            <input type="number" step="0.01" wire:model="payment_amount"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0.00">
                            @error('payment_amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Method') }}</label>
                            <select wire:model="payment_method"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                                <option value="credit_card">{{ __('Credit Card') }}</option>
                                <option value="cash">{{ __('Cash') }}</option>
                                <option value="check">{{ __('Check') }}</option>
                                <option value="paypal">{{ __('PayPal') }}</option>
                                <option value="stripe">{{ __('Stripe') }}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date') }}</label>
                            <input type="date" wire:model="payment_date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('payment_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes (optional)') }}</label>
                            <textarea wire:model="payment_notes" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>
                        <button type="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition disabled:opacity-50">
                            <svg wire:loading wire:target="recordPayment" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ __('Record Payment') }}</span>
                        </button>
                    </form>
                </div>
            @endif

            @if($invoice->payments->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Payment History') }}</h3>
                    <div class="space-y-3">
                        @foreach($invoice->payments as $payment)
                            <div class="flex justify-between items-start pb-3 border-b last:border-0">
                                <div>
                                    <p class="font-medium">
                                        {{ $invoice->currency_symbol }}{{ number_format($payment->amount, 2) }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $payment->date->format('M d, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">{{ __(ucfirst(str_replace('_', ' ', $payment->method))) }}
                                    </p>
                                    <button wire:click="deletePayment({{ $payment->id }})"
                                        wire:confirm="{{ __('Delete this payment?') }}"
                                        class="text-xs text-red-600 hover:text-red-700">{{ __('Delete') }}</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($showPaidModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="text-xl font-bold text-gray-900">{{ __('Mark as Paid') }}</h3>
                    <button wire:click="closePaidModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form wire:submit="markAsPaid">
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Payment Date') }} *</label>
                            <input type="date" wire:model="payment_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @error('payment_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Source') }} *</label>
                            <select wire:model="paymentSource"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="bank">{{ __('Bank') }}</option>
                                <option value="cash">{{ __('Cash (Kasse)') }}</option>
                            </select>
                            @error('paymentSource') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }} *</label>
                            <input type="text" wire:model="paymentDescription"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @error('paymentDescription') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50 border-t flex justify-end gap-3">
                        <button type="button" wire:click="closePaidModal()"
                            class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-sm transition font-bold disabled:opacity-50 flex items-center gap-2">
                            <svg wire:loading wire:target="markAsPaid" class="animate-spin h-4 w-4 text-white" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ __('Save Payment') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>