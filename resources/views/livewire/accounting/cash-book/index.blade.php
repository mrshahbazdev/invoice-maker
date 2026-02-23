@php $title = __('Cash Book'); @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Cash Book') }}</h2>
            <p class="text-gray-600">{{ __('Professional financial overview') }}</p>
        </div>
        <div class="flex gap-4">
            <div class="bg-green-50 px-4 py-2 rounded-lg border border-green-100 shadow-sm">
                <span class="text-xs font-bold text-green-600 uppercase tracking-wider">{{ __('Income') }}</span>
                <p class="text-xl font-extrabold text-green-700 tracking-tight">
                    {{ number_format($incomeTotal, 2, ',', '.') }} €</p>
            </div>
            <div class="bg-red-50 px-4 py-2 rounded-lg border border-red-100 shadow-sm">
                <span class="text-xs font-bold text-red-600 uppercase tracking-wider">{{ __('Expense') }}</span>
                <p class="text-xl font-extrabold text-red-700 tracking-tight">
                    {{ number_format($expenseTotal, 2, ',', '.') }} €</p>
            </div>
            <div class="bg-blue-600 px-6 py-2 rounded-lg shadow-md flex flex-col justify-center">
                <span class="text-xs font-bold text-blue-100 uppercase tracking-wider">{{ __('Balance') }}</span>
                <p class="text-xl font-extrabold text-white tracking-tight">{{ number_format($balance, 2, ',', '.') }} €
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Filters -->
        <div class="p-6 bg-gray-50/50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('Search') }}</label>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Partner, Booking #...') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('Type') }}</label>
                    <select wire:model.live="type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="income">{{ __('Income') }}</option>
                        <option value="expense">{{ __('Expense') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('Source') }}</label>
                    <select wire:model.live="source"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">{{ __('All Sources') }}</option>
                        <option value="bank">{{ __('Bank') }}</option>
                        <option value="cash">{{ __('Cash (Kasse)') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('From') }}</label>
                    <input type="date" wire:model.live="startDate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ __('To') }}</label>
                    <input type="date" wire:model.live="endDate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-[13px] border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-3 py-3 w-8"></th>
                        <th class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('booking_number')">
                            {{ __('Booking #') }}
                            @if($sortBy === 'booking_number') <span
                            class="text-[10px]">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">
                            {{ __('Reference') }}
                        </th>
                        <th class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">
                            {{ __('Doc Date') }}
                        </th>
                        <th class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider text-center">
                            {{ __('Status') }}
                        </th>
                        <th class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">
                            {{ __('Partner / Company') }}
                        </th>
                        <th class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('date')">
                            {{ __('Payment Date') }}
                            @if($sortBy === 'date') <span
                            class="text-[10px]">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th class="px-3 py-3 text-right font-bold text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('amount')">
                            {{ __('Amount') }}
                            @if($sortBy === 'amount') <span
                            class="text-[10px]">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                        </th>
                        <th class="px-3 py-3 text-right font-bold text-gray-500 uppercase tracking-wider">
                            {{ __('Diff.') }}
                        </th>
                        <th class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">
                            {{ __('Category') }}
                        </th>
                        <th class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">
                            {{ __('Entry Date') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($entries as $entry)
                        <tr class="hover:bg-gray-50 transition-colors {{ $loop->odd ? 'bg-white' : 'bg-gray-50/20' }}">
                            <td class="px-3 py-2 text-center">
                                <span
                                    class="inline-block w-2.5 h-2.5 rounded-full {{ $entry->type === 'income' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-500">
                                {{ $entry->booking_number }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-900 font-semibold italic">
                                {{ $entry->reference_number ?? '-' }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-600">
                                {{ $entry->document_date ? $entry->document_date->format('d.m.Y') : ($entry->invoice ? $entry->invoice->invoice_date->format('d.m.Y') : $entry->date->format('d.m.Y')) }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-center text-[11px] text-gray-500">
                                {{ $entry->type === 'income' ? __('vollständig bezahlt') : __('Bezahlt') }}
                            </td>
                            <td class="px-3 py-2 text-gray-900 font-bold max-w-xs truncate">
                                {{ $entry->partner_name ?? ($entry->invoice && $entry->invoice->client ? ($entry->invoice->client->company_name ?? $entry->invoice->client->name) : $entry->description) }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-600 font-medium">
                                {{ $entry->date->format('d.m.Y') }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-right font-extrabold text-gray-900">
                                {{ number_format($entry->amount, 2, ',', '.') }} €
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-right text-gray-400">
                                0,00 €
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-600">
                                <span
                                    class="px-2 py-0.5 rounded bg-gray-100 border border-gray-200 text-[10px] font-bold text-gray-600 uppercase tracking-tighter">
                                    {{ $entry->category->name ?? ($entry->type === 'income' ? __('Einnahmen') : __('Allgemeines')) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-400 text-[11px]">
                                {{ $entry->created_at->format('d.m.y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p>{{ __('No entries found in this period.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($entries->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $entries->links() }}
            </div>
        @endif
    </div>
</div>