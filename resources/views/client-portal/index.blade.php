<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-page">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Client Portal') }} - {{ $business->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>

<body class="h-full font-sans antialiased text-txmain">
    <div class="min-h-full">
        <!-- Top Navigation -->
        <nav class="bg-card shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        @if($business->logo)
                            <img src="{{ Storage::url($business->logo) }}" alt="{{ $business->name }}" class="h-8 w-auto">
                        @else
                            <span class="text-xl font-bold tracking-tight text-brand-600">{{ $business->name }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="md:flex md:items-center md:justify-between mb-8">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-2xl font-bold leading-7 text-txmain sm:truncate sm:text-3xl sm:tracking-tight">
                            {{ __('Welcome, :name', ['name' => $client->name]) }}
                        </h2>
                        <p class="mt-1 flex text-sm text-gray-500">
                            {{ __('View all your invoices and pending estimates here.') }}
                        </p>
                    </div>
                </div>

                <!-- Stats -->
                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
                    <div class="overflow-hidden rounded-2xl bg-card px-4 py-5 shadow-sm border border-gray-100 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">{{ __('Outstanding Balance') }}</dt>
                        <dd class="mt-1 text-3xl font-bold tracking-tight text-brand-600">
                            {{ $client->currency ?? $business->currency }}{{ number_format($totalDue, 2) }}
                        </dd>
                    </div>

                    <div class="overflow-hidden rounded-2xl bg-card px-4 py-5 shadow-sm border border-gray-100 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">{{ __('Total Billed') }}</dt>
                        <dd class="mt-1 text-3xl font-bold tracking-tight text-txmain">
                            {{ $client->currency ?? $business->currency }}{{ number_format($totalBilled, 2) }}
                        </dd>
                    </div>

                    <div class="overflow-hidden rounded-2xl bg-card px-4 py-5 shadow-sm border border-gray-100 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">{{ __('Total Paid') }}</dt>
                        <dd class="mt-1 text-3xl font-bold tracking-tight text-green-600">
                            {{ $client->currency ?? $business->currency }}{{ number_format($totalPaid, 2) }}
                        </dd>
                    </div>
                </dl>

                <!-- Invoices Table -->
                <div class="bg-card shadow-sm border border-gray-100 sm:rounded-2xl overflow-hidden mb-8">
                    <div
                        class="px-4 py-5 sm:px-6 border-b border-gray-100 flex justify-between items-center bg-page/50">
                        <h3 class="text-lg font-bold leading-6 text-txmain">{{ __('Recent Invoices') }}</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-card">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:pl-6">
                                        {{ __('Invoice #') }}</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        {{ __('Status') }}</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        {{ __('Date') }}</th>
                                    <th scope="col"
                                        class="px-3 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        {{ __('Amount Due') }}</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">{{ __('View') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-card">
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-txmain sm:pl-6">
                                            {{ $invoice->invoice_number }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            @if($invoice->status === 'paid')
                                                <span
                                                    class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ __('Paid') }}</span>
                                            @elseif($invoice->status === 'sent')
                                                <span
                                                    class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{ __('Sent') }}</span>
                                            @elseif($invoice->status === 'overdue')
                                                <span
                                                    class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{ __('Overdue') }}</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ ucfirst($invoice->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $invoice->invoice_date->translatedFormat('M d, Y') }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm text-right font-semibold text-txmain">
                                            {{ $invoice->currency_symbol }}{{ number_format($invoice->amount_due, 2) }}
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="{{ URL::signedRoute('invoices.public.show', $invoice->id) }}"
                                                class="text-brand-600 hover:text-brand-900 font-semibold">{{ __('View') }}<span
                                                    class="sr-only">, {{ $invoice->invoice_number }}</span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center">
                                            <p class="text-sm text-gray-500">{{ __('No invoices found.') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($estimates->count() > 0)
                    <!-- Estimates Table -->
                    <div class="bg-card shadow-sm border border-gray-100 sm:rounded-2xl overflow-hidden">
                        <div
                            class="px-4 py-5 sm:px-6 border-b border-gray-100 flex justify-between items-center bg-page/50">
                            <h3 class="text-lg font-bold leading-6 text-txmain">{{ __('Estimates') }}</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-card">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:pl-6">
                                            {{ __('Estimate #') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                            {{ __('Status') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                            {{ __('Date') }}</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                            {{ __('Total') }}</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">{{ __('View') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-card">
                                    @foreach($estimates as $estimate)
                                        <tr>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-txmain sm:pl-6">
                                                {{ $estimate->invoice_number }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ ucfirst($estimate->status) }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $estimate->invoice_date->translatedFormat('M d, Y') }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-3 py-4 text-sm text-right font-semibold text-txmain">
                                                {{ $estimate->currency_symbol }}{{ number_format($estimate->grand_total, 2) }}
                                            </td>
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="{{ URL::signedRoute('invoices.public.show', $estimate->id) }}"
                                                    class="text-brand-600 hover:text-brand-900 font-semibold">{{ __('View') }}<span
                                                        class="sr-only">, {{ $estimate->invoice_number }}</span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </main>
    </div>
</body>

</html>