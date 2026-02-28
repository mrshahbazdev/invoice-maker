@php $title = __('Financial Reports'); @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-txmain">{{ __('Financial & Tax Reports') }}</h2>
            <p class="text-txmain">{{ __('View your revenue and download tax summaries for your accountant.') }}</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="exportTaxSummary" wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 shadow-sm transition">
                <svg wire:loading wire:target="exportTaxSummary" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <svg wire:loading.remove wire:target="exportTaxSummary" class="w-4 h-4 mr-2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                {{ __('Download Tax Prep (CSV)') }}
            </button>
        </div>
    </div>

    <!-- Date Filters -->
    <div class="bg-card rounded-lg shadow p-4 border border-gray-100 mb-8 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Start Date') }}</label>
            <input type="date" wire:model.live="startDate"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('End Date') }}</label>
            <input type="date" wire:model.live="endDate"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500">
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
        <div class="bg-card rounded-xl shadow-sm border border-gray-100 p-6">
            <dt class="truncate text-sm font-medium text-gray-500">{{ __('Net Collected Revenue') }}</dt>
            <dd class="mt-2 text-3xl font-bold tracking-tight text-green-600">
                {{ auth()->user()->currentBusiness->currency ?? 'USD' }} {{ number_format($totalRevenue, 2) }}
            </dd>
            <p class="mt-1 text-xs text-gray-500">{{ __('Only includes Paid invoices') }}</p>
        </div>

        <div class="bg-card rounded-xl shadow-sm border border-gray-100 p-6">
            <dt class="truncate text-sm font-medium text-gray-500">{{ __('Outstanding Balance') }}</dt>
            <dd class="mt-2 text-3xl font-bold tracking-tight text-red-600">
                {{ auth()->user()->currentBusiness->currency ?? 'USD' }} {{ number_format($outstandingBalance, 2) }}
            </dd>
            <p class="mt-1 text-xs text-gray-500">{{ __('Unpaid Sent/Overdue invoices') }}</p>
        </div>

        <div class="bg-card rounded-xl shadow-sm border border-gray-100 p-6">
            <dt class="truncate text-sm font-medium text-brand-600">{{ __('Total Tax Collected') }}</dt>
            <dd class="mt-2 text-3xl font-bold tracking-tight text-brand-700">
                {{ auth()->user()->currentBusiness->currency ?? 'USD' }} {{ number_format($totalTaxCollected, 2) }}
            </dd>
            <p class="mt-1 text-xs text-brand-500/80">{{ __('Ready for tax reporting') }}</p>
        </div>
    </div>

    <!-- Recent Paid Invoices Table for Tax Reference -->
    <div class="bg-card shadow-sm border border-gray-100 sm:rounded-xl overflow-hidden mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-100">
            <h3 class="text-lg font-bold leading-6 text-txmain">{{ __('Paid Invoices (Selected Period)') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-card">
                    <tr>
                        <th
                            class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:pl-6">
                            {{ __('Invoice #') }}</th>
                        <th class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Client') }}</th>
                        <th class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Date') }}</th>
                        <th class="px-3 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Tax') }}</th>
                        <th class="px-3 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            {{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-page/30">
                    @forelse($recentPaidInvoices as $invoice)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-txmain sm:pl-6">
                                {{ $invoice->invoice_number }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-txmain">{{ $invoice->client->name ?? '-' }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{ $invoice->invoice_date->format('M d, Y') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium text-brand-600">
                                {{ $invoice->currency_symbol }}{{ number_format($invoice->tax_total, 2) }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-semibold text-green-600">
                                {{ $invoice->currency_symbol }}{{ number_format($invoice->grand_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-sm text-gray-500">
                                {{ __('No paid invoices found in this date range.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>