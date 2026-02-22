@php $title = 'Invoices'; @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Invoices</h2>
            <p class="text-gray-600">Manage your invoices</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('invoices.create', ['quick' => 1]) }}"
                class="bg-white text-gray-700 py-2 px-4 rounded-lg border border-gray-300 shadow-sm hover:bg-gray-50 transition duration-200 text-center font-medium">
                ⚡ Quick Invoice
            </a>
            <a href="{{ route('invoices.create') }}"
                class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 shadow-sm transition duration-200 text-center font-medium">
                + Create Invoice
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b flex flex-col md:flex-row gap-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search invoices..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <select wire:model.live="status"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="paid">Paid</option>
                <option value="overdue">Overdue</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('invoice_number')">
                            Invoice
                            @if($sortBy === 'invoice_number')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Client</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('invoice_date')">
                            Date
                            @if($sortBy === 'invoice_date')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Due Date</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Amount</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('invoices.show', $invoice) }}"
                                        class="text-blue-600 hover:text-blue-700 font-medium">
                                        {{ $invoice->invoice_number }}
                                    </a>
                                    @if($invoice->is_recurring)
                                        <span
                                            class="inline-flex items-center rounded-md bg-purple-50 px-1.5 py-0.5 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10"
                                            title="Recurring Invoice">
                                            <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                            R
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-600">{{ $invoice->client->name }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $invoice->invoice_date->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $invoice->due_date->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-gray-900 font-medium">
                                {{ $invoice->currency_symbol }}{{ number_format($invoice->grand_total, 2) }}
                            </td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $invoice->status_color }}-100 text-{{ $invoice->status_color }}-700">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('invoices.show', $invoice) }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">View</a>
                                    @if($invoice->status === 'draft')
                                        <a href="{{ route('invoices.edit', $invoice) }}"
                                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                                    @endif
                                    <button wire:click="delete({{ $invoice->id }})"
                                        wire:confirm="Are you sure you want to delete this invoice?"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500">
                                No invoices found. <a href="{{ route('invoices.create') }}"
                                    class="text-blue-600 hover:text-blue-700">Create your first invoice</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($invoices->hasPages())
            <div class="p-4 border-t flex justify-between items-center">
                <span class="text-sm text-gray-600">
                    Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} results
                </span>
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
</div>