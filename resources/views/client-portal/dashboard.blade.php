<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Dashboard - {{ config('app.name', 'InvoiceMaker') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #111827;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left side -->
                <div class="flex items-center justify-between">
                    <div class="flex-shrink-0 flex items-center">
                        <div
                            class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg mr-3 shadow-md shadow-indigo-600/20">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-900 leading-tight">Client Portal</h1>
                            <p class="text-xs text-gray-500 font-medium">Welcome, {{ auth()->user()->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('client.settings') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors duration-150">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if (session('success'))
            <div class="rounded-md bg-green-50 p-4 mb-6 ring-1 ring-green-500/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">My
                    Invoices</h2>
                <p class="mt-1 text-sm text-gray-500">Overview of your billing history and outstanding balances.</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
            <!-- Paid -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-green-50 rounded-lg">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Total Paid</dt>
                                <dd>
                                    <div class="text-2xl font-semibold text-gray-900">
                                        ${{ number_format($totalPaid, 2) }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-yellow-50 rounded-lg">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Pending</dt>
                                <dd>
                                    <div class="text-2xl font-semibold text-gray-900">
                                        ${{ number_format($totalPending, 2) }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overdue -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-red-50 rounded-lg">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Overdue</dt>
                                <dd>
                                    <div class="text-2xl font-semibold text-gray-900">
                                        ${{ number_format($totalOverdue, 2) }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
            <div class="border-b border-gray-200 bg-white px-6 py-5">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Recent Transactions</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Invoice #
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">From</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Amount
                                Due</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Status
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Action</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white" x-data>
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-gray-50 transition-colors cursor-pointer group"
                                @click="$el.nextElementSibling.classList.toggle('hidden')">
                                <td
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 group-hover:text-blue-600 transition-colors">
                                    {{ $invoice->invoice_number }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $invoice->business->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $invoice->invoice_date->format('M d, Y') }}
                                    @if($invoice->due_date && $invoice->status !== 'paid')
                                        <div
                                            class="text-xs {{ $invoice->due_date->isPast() ? 'text-red-500 font-medium' : 'text-gray-400' }} mt-0.5">
                                            Due: {{ $invoice->due_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 text-right font-medium">
                                    ${{ number_format($invoice->amount_due, 2) }}
                                    @if($invoice->amount_paid > 0)
                                        <div class="text-xs font-normal text-gray-500 mt-0.5">
                                            of ${{ number_format($invoice->grand_total, 2) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                    @php
                                        $statusClass = match ($invoice->status) {
                                            'paid' => 'bg-green-50 text-green-700 ring-green-600/20',
                                            'overdue' => 'bg-red-50 text-red-700 ring-red-600/10',
                                            'sent', 'viewed' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                            default => 'bg-gray-50 text-gray-600 ring-gray-500/10'
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td
                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('invoices.public.download', $invoice->id) }}"
                                            class="text-gray-400 hover:text-gray-600" title="Download PDF">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </a>
                                        <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('invoices.public.show', $invoice->id) }}"
                                            target="_blank"
                                            class="inline-flex items-center rounded bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-600 shadow-sm hover:bg-blue-100">
                                            View & Pay
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Expandable Details Row -->
                            <tr class="hidden bg-gray-50/50">
                                <td colspan="6" class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <h4 class="font-medium mb-3 text-gray-700">Invoice Items</h4>
                                        <div class="ring-1 ring-gray-200 rounded-lg overflow-hidden bg-white">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Item</th>
                                                        <th scope="col"
                                                            class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Qty</th>
                                                        <th scope="col"
                                                            class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Price</th>
                                                        <th scope="col"
                                                            class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                    @foreach($invoice->items as $item)
                                                        <tr>
                                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $item->description }}
                                                            </td>
                                                            <td class="px-3 py-2 text-sm text-gray-500 text-right">
                                                                {{ $item->quantity }}
                                                            </td>
                                                            <td class="px-3 py-2 text-sm text-gray-500 text-right">
                                                                ${{ number_format($item->unit_price, 2) }}</td>
                                                            <td class="px-3 py-2 text-sm font-medium text-gray-900 text-right">
                                                                ${{ number_format($item->total, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="bg-gray-50">
                                                    <tr>
                                                        <td colspan="3" class="px-3 py-2 text-right text-sm text-gray-500">
                                                            Subtotal</td>
                                                        <td class="px-3 py-2 text-right text-sm text-gray-900">
                                                            ${{ number_format($invoice->subtotal, 2) }}</td>
                                                    </tr>
                                                    @if($invoice->tax_total > 0)
                                                        <tr>
                                                            <td colspan="3" class="px-3 py-2 text-right text-sm text-gray-500">
                                                                Tax</td>
                                                            <td class="px-3 py-2 text-right text-sm text-gray-900">
                                                                ${{ number_format($invoice->tax_total, 2) }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr class="border-t border-gray-200">
                                                        <td colspan="3"
                                                            class="px-3 py-3 text-right text-sm font-semibold text-gray-900">
                                                            Total</td>
                                                        <td class="px-3 py-3 text-right text-sm font-bold text-gray-900">
                                                            ${{ number_format($invoice->grand_total, 2) }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        @if($invoice->notes)
                                            <div class="mt-4 text-sm text-gray-500">
                                                <strong>Notes:</strong> {{ $invoice->notes }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No invoices</h3>
                                    <p class="mt-1 text-sm text-gray-500">There are no invoices currently associated with
                                        your account.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($invoices->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>

    </main>

</body>

</html>