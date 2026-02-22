@php $title = $invoice->isEstimate() ? __('View Estimate') : __('View Invoice'); @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }} {{ __('Details') }}</h2>
            <p class="text-gray-600">{{ $invoice->invoice_number }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @if($invoice->status === 'draft')
                <button wire:click="markAsSent"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    {{ __('Mark as Sent') }}
                </button>
            @endif
            @if(in_array($invoice->status, ['sent', 'overdue']))
                <button wire:click="markAsPaid"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    {{ __('Mark as Paid') }}
                </button>
            @endif
            @if($invoice->status === 'sent' && $invoice->due_date->isPast())
                <button wire:click="markAsOverdue"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                    {{ __('Mark as Overdue') }}
                </button>
            @endif
            @if(in_array($invoice->status, ['draft', 'sent', 'overdue']))
                <button wire:click="cancelInvoice"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    {{ __('Cancel') }}
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
            <button wire:click="sendEmail"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                {{ __('Email') }} {{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }}
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
                <button wire:click="convertToInvoice" wire:confirm="{{ __('Convert this estimate to a standard invoice?') }}"
                    class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 shadow-sm transition duration-200 text-center font-medium">
                    {{ __('Convert to Invoice') }}
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
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">{{ $invoice->isEstimate() ? __('ESTIMATE') : __('INVOICE') }} {{ __('TO') }}</h4>
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

                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">{{ $invoice->isEstimate() ? __('ESTIMATE') : __('INVOICE') }} {{ __('INFO') }}</h4>
                <div class="space-y-1">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">{{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }} #:</span>
                        <span class="font-medium text-gray-900">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">{{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }} {{ __('Date') }}:</span>
                        <span class="font-medium text-gray-900">{{ $invoice->invoice_date->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">{{ $invoice->isEstimate() ? __('Expiration') : __('Due') }} {{ __('Date') }}:</span>
                        <span class="font-medium text-gray-900">{{ $invoice->due_date->format('M d, Y') }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 text-sm font-semibold text-gray-700">{{ __('Description') }}</th>
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
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
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
                        <button type="submit"
                            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                            {{ __('Record Payment') }}
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
                                        {{ $invoice->currency_symbol }}{{ number_format($payment->amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $payment->date->format('M d, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">{{ __(ucfirst(str_replace('_', ' ', $payment->method))) }}</p>
                                    <button wire:click="deletePayment({{ $payment->id }})" wire:confirm="{{ __('Delete this payment?') }}"
                                        class="text-xs text-red-600 hover:text-red-700">{{ __('Delete') }}</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>