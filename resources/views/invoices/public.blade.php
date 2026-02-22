<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }} {{ $invoice->invoice_number }} -
        {{ $invoice->business->name }}
    </title>
    @vite(['resources/css/app.css'])
    <style>
        /* A4 aspect ratio wrapper for web preview */
        .invoice-preview-wrapper {
            width: 100%;
            max-width: 21cm;
            /* A4 width */
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .invoice-preview-inner {
            padding: 2cm;
            min-height: 29.7cm;
            /* A4 height */
        }

        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none !important;
            }

            .invoice-preview-wrapper {
                box-shadow: none;
                max-width: none;
                margin: 0;
            }

            .invoice-preview-inner {
                padding: 0;
                min-height: auto;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen pb-12">
    <!-- Top Action Bar -->
    <div class="bg-white shadow-sm border-b sticky top-0 z-50 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-900">{{ $invoice->business->name }}</span>
                    <span class="ml-4 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }} {{ $invoice->invoice_number }}
                    </span>
                    @if($invoice->status === 'paid')
                        <span class="ml-2 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ __('Paid') }}
                        </span>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="window.print()" class="text-gray-600 hover:text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        {{ __('Print') }}
                    </button>
                    <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('client.register', ['invoice' => $invoice->id]) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        {{ __('Save to My Account') }}
                    </a>
                    @if(!$invoice->isEstimate() && $invoice->status !== 'paid' && $invoice->business->stripe_onboarding_complete)
                        <a href="{{ route('invoices.pay', ['invoice' => $invoice->id]) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M13.976 9.15c-2.172-.806-3.356-1.143-3.356-2.076 0-.776.78-1.42 2.308-1.42 1.34 0 2.872.54 4.02 1.258l1.325-3.56A10.824 10.824 0 0012.784 2c-3.792 0-6.19 1.947-6.19 4.796 0 3.737 4.197 4.547 5.926 5.093 2.14.678 3.12 1.256 3.12 2.238 0 .86-.88 1.488-2.617 1.488-1.503 0-3.32-.61-4.706-1.487l-1.393 3.61c1.472.8 3.518 1.257 5.564 1.257 3.96 0 6.33-1.928 6.33-4.887 0-3.5-3.615-4.14-5.842-5.02z" />
                            </svg>
                            {{ __('Pay with Card') }}
                        </a>
                    @endif
                    <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('invoices.public.download', ['invoice' => $invoice->id]) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        {{ __('Download PDF') }}
                    </a>
                    @if($invoice->isEstimate() && $invoice->status === 'sent')
                        <div class="flex items-center space-x-2">
                            <form
                                action="{{ \Illuminate\Support\Facades\URL::signedRoute('invoices.public.revision', ['invoice' => $invoice->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                                    {{ __('Request Revision') }}
                                </button>
                            </form>
                            <form
                                action="{{ \Illuminate\Support\Facades\URL::signedRoute('invoices.public.approve', ['invoice' => $invoice->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                    {{ __('Approve Estimate') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        @if(request()->has('success'))
            <div class="max-w-2xl mx-auto mb-8 bg-green-50 border-l-4 border-green-400 p-4 no-print">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ __('Payment successful! Your invoice has been updated.') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(request()->has('cancelled'))
            <div class="max-w-2xl mx-auto mb-8 bg-yellow-50 border-l-4 border-yellow-400 p-4 no-print">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">{{ __('Payment was cancelled. You can try again below.') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($invoice->status === 'paid')
            <div class="max-w-2xl mx-auto mb-8 bg-green-50 border-l-4 border-green-400 p-4 no-print">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {{ __('This invoice has been fully paid. Thank you!') }}
                        </p>
                    </div>
                </div>
            </div>
        @elseif($invoice->due_date->isPast())
            <div class="max-w-2xl mx-auto mb-8 bg-red-50 border-l-4 border-red-400 p-4 no-print">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            {{ __('This invoice is past due. Please process payment as soon as possible.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="invoice-preview-wrapper mt-8">
            <div class="invoice-preview-inner">
                {{-- Instead of duplicating PDF layout, we use an iframe pointing to a web version or render it here.
                For simplicity, we directly render the blade view content but within this wrapper --}}
                @php
                    $template = $invoice->template;
                    $primaryColor = $template->primary_color ?? '#000000';
                    $fontFamily = $template->font_family ?? 'Arial, Helvetica, sans-serif';
                    $enableQr = $template->enable_qr ?? false;
                @endphp
                <div style="font-family: {{ $fontFamily }}; color: #333;" class="bg-white">

                    <!-- Header -->
                    <div
                        class="flex flex-col md:flex-row justify-between items-start md:items-center pb-8 border-b border-gray-100 mb-10">
                        <div class="w-full md:w-1/2 mb-6 md:mb-0">
                            @if($invoice->business->logo)
                                <img src="{{ Storage::url($invoice->business->logo) }}" alt="Logo"
                                    class="max-h-20 max-w-[200px] mb-4 object-contain">
                            @else
                                <h2 class="text-3xl font-extrabold tracking-tight" style="color: {{ $primaryColor }};">
                                    {{ $invoice->business->name }}
                                </h2>
                            @endif
                            <div class="mt-4 text-sm text-gray-500 leading-relaxed space-y-1">
                                @if($invoice->business->address)
                                <div>{!! nl2br(e($invoice->business->address)) !!}</div> @endif
                                @if($invoice->business->phone)
                                <div>{{ $invoice->business->phone }}</div> @endif
                                @if($invoice->business->email)
                                <div>{{ $invoice->business->email }}</div> @endif
                                @if($invoice->business->tax_number)
                                    <div class="mt-2 text-gray-400">{{ __('Tax ID') }}: {{ $invoice->business->tax_number }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 flex flex-col md:items-end text-left md:text-right">
                            <div class="flex items-start md:items-center justify-start md:justify-end gap-6 mb-6">
                                @if($enableQr)
                                    @php
                                        $qrUrl = route('invoices.public.show', $invoice->id);
                                        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(72)->generate($qrUrl));
                                    @endphp
                                    <div class="p-1.5 bg-white rounded-xl shadow-sm border border-gray-100">
                                        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code"
                                            class="w-[72px] h-[72px]">
                                    </div>
                                @endif
                                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-widest"
                                    style="color: {{ $primaryColor }}; opacity: 0.9;">
                                    {{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }}
                                </h1>
                            </div>

                            <div
                                class="bg-gray-50 rounded-2xl p-6 shadow-sm border border-gray-100 inline-block text-left w-full max-w-sm">
                                <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-200">
                                    <span
                                        class="text-xs uppercase tracking-wider font-semibold text-gray-500">{{ $invoice->isEstimate() ? __('Estimate') : __('Invoice') }}
                                        {{ __('No') }}:</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $invoice->invoice_number }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-3">
                                    <span
                                        class="text-xs uppercase tracking-wider font-semibold text-gray-500">{{ __('Date') }}:</span>
                                    <span
                                        class="text-sm font-medium text-gray-700">{{ $invoice->invoice_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-4">
                                    <span
                                        class="text-xs uppercase tracking-wider font-semibold text-gray-500">{{ $invoice->isEstimate() ? __('Expiry Date') : __('Due Date') }}:</span>
                                    <span
                                        class="text-sm font-medium text-gray-700">{{ $invoice->due_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-3 mt-1"
                                    style="border-top: 1.5px dashed {{ $primaryColor }}40;">
                                    <span class="text-xs uppercase tracking-wider font-bold"
                                        style="color: {{ $primaryColor }};">{{ __('Balance Due') }}</span>
                                    <span class="text-xl font-black"
                                        style="color: {{ $primaryColor }};">{{ $invoice->currency_symbol }}{{ number_format($invoice->amount_due, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing To -->
                    <div class="mb-12 pl-6 border-l-4" style="border-color: {{ $primaryColor }}30;">
                        <h3 class="text-xs font-bold uppercase tracking-widest mb-3"
                            style="color: {{ $primaryColor }};">
                            {{ __('Bill To') }}
                        </h3>
                        <div class="text-sm text-gray-700 leading-relaxed">
                            <strong class="text-base text-gray-900 block mb-1">{{ $invoice->client->name }}</strong>
                            @if($invoice->client->company_name)
                            <div class="text-gray-600 font-medium">{{ $invoice->client->company_name }}</div> @endif
                            @if($invoice->client->address)
                            <div class="mt-2 text-gray-500">{!! nl2br(e($invoice->client->address)) !!}</div> @endif
                            <div class="mt-2 text-gray-500">
                                @if($invoice->client->phone) <span class="block">{{ $invoice->client->phone }}</span>
                                @endif
                                @if($invoice->client->email) <a href="mailto:{{ $invoice->client->email }}"
                                    class="text-gray-500 hover:text-gray-900 underline decoration-gray-300 underline-offset-2">{{ $invoice->client->email }}</a>
                                @endif
                            </div>
                            @if($invoice->client->tax_number)
                                <div class="mt-3 text-xs text-gray-400">{{ __('Tax ID') }}:
                                    {{ $invoice->client->tax_number }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table (Desktop) -->
                    <div class="mb-10 rounded-2xl overflow-hidden border border-gray-200 hidden md:block">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr style="background-color: {{ $primaryColor }}; color: #ffffff;">
                                    <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider">
                                        {{ __('Description') }}
                                    </th>
                                    <th class="py-4 px-4 text-xs font-bold uppercase tracking-wider text-center w-24">
                                        {{ __('Quantity') }}
                                    </th>
                                    <th class="py-4 px-4 text-xs font-bold uppercase tracking-wider text-right w-32">
                                        {{ __('Price') }}
                                    </th>
                                    @if($template->show_tax ?? true)
                                        <th class="py-4 px-4 text-xs font-bold uppercase tracking-wider text-right w-24">
                                            {{ __('Tax') }}
                                        </th>
                                    @endif
                                    <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-right w-32">
                                        {{ __('Total') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white text-gray-700 text-sm">
                                @foreach($invoice->items as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-5 px-6">
                                            <p class="font-bold text-gray-900">{{ explode(' - ', $item->description)[0] }}
                                            </p>
                                            @if(count(explode(' - ', $item->description)) > 1)
                                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                                    {{ substr($item->description, strpos($item->description, ' - ') + 3) }}
                                                </p>
                                            @endif
                                        </td>
                                        <td class="py-5 px-4 text-center text-gray-600 font-medium">{{ $item->quantity }}
                                        </td>
                                        <td class="py-5 px-4 text-right text-gray-600">
                                            {{ $invoice->currency_symbol }}{{ number_format($item->unit_price, 2) }}
                                        </td>
                                        @if($template->show_tax ?? true)
                                            <td class="py-5 px-4 text-right text-gray-500">
                                                @if($item->tax_rate > 0)
                                                    {{ $item->tax_rate }}% <span
                                                        class="block text-[11px] text-gray-400 mt-0.5">({{ $invoice->currency_symbol }}{{ number_format($item->tax_amount, 2) }})</span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="py-5 px-6 text-right font-bold text-gray-900">
                                            {{ $invoice->currency_symbol }}{{ number_format($item->total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Items Card View (Mobile) -->
                    <div class="mb-10 space-y-4 md:hidden">
                        @foreach($invoice->items as $item)
                            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-3">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">{{ explode(' - ', $item->description)[0] }}</p>
                                        @if(count(explode(' - ', $item->description)) > 1)
                                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                                {{ substr($item->description, strpos($item->description, ' - ') + 3) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-right ml-4">
                                        <span class="text-sm font-black" style="color: {{ $primaryColor }};">
                                            {{ $invoice->currency_symbol }}{{ number_format($item->total, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-xs pt-2 border-t border-gray-200">
                                    <div class="flex space-x-4">
                                        <div>
                                            <span
                                                class="text-gray-400 uppercase tracking-widest font-bold text-[10px]">{{ __('Qty') }}</span>
                                            <span class="block font-medium text-gray-900">{{ $item->quantity }}</span>
                                        </div>
                                        <div>
                                            <span
                                                class="text-gray-400 uppercase tracking-widest font-bold text-[10px]">{{ __('Price') }}</span>
                                            <span
                                                class="block font-medium text-gray-900">{{ $invoice->currency_symbol }}{{ number_format($item->unit_price, 2) }}</span>
                                        </div>
                                    </div>
                                    @if(($template->show_tax ?? true) && $item->tax_rate > 0)
                                        <div class="text-right">
                                            <span
                                                class="text-gray-400 uppercase tracking-widest font-bold text-[10px]">{{ __('Tax') }}</span>
                                            <span class="block font-medium text-gray-900">{{ $item->tax_rate }}%</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totals Section -->
                    <div class="flex flex-col lg:flex-row justify-between gap-12">
                        <!-- Notes / Payment Terms -->
                        <div class="w-full lg:w-3/5 order-2 lg:order-1">
                            @if($invoice->notes || ($template->payment_terms ?? false))
                                <div class="bg-gray-50/50 rounded-2xl p-6 border border-gray-100">
                                    @if($invoice->notes)
                                        <div class="mb-6">
                                            <h4 class="text-xs font-bold uppercase tracking-widest mb-2"
                                                style="color: {{ $primaryColor }};">{{ __('Notes') }}</h4>
                                            <p class="text-sm text-gray-600 leading-relaxed">{{ $invoice->notes }}</p>
                                        </div>
                                    @endif

                                    @if($template->payment_terms ?? false)
                                        <div>
                                            <h4 class="text-xs font-bold uppercase tracking-widest mb-2"
                                                style="color: {{ $primaryColor }};">{{ __('Payment Terms & Instructions') }}
                                            </h4>
                                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                                                {!! e($template->payment_terms) !!}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Totals Table -->
                        <div class="w-full lg:w-2/5 order-1 lg:order-2">
                            <div class="bg-gray-50 rounded-2xl p-6 shadow-sm border border-gray-100 text-sm">
                                <div class="flex justify-between py-2 text-gray-600">
                                    <span>{{ __('Subtotal') }}:</span>
                                    <span
                                        class="font-medium text-gray-900">{{ $invoice->currency_symbol }}{{ number_format($invoice->subtotal, 2) }}</span>
                                </div>
                                @if($template->show_tax ?? true)
                                    <div class="flex justify-between py-2 text-gray-600">
                                        <span>{{ __('Total Tax') }}:</span>
                                        <span
                                            class="font-medium text-gray-900">{{ $invoice->currency_symbol }}{{ number_format($invoice->tax_total, 2) }}</span>
                                    </div>
                                @endif
                                @if(($template->show_discount ?? true) && $invoice->discount > 0)
                                    <div class="flex justify-between py-2 text-gray-600">
                                        <span>{{ __('Discount') }}:</span>
                                        <span
                                            class="font-medium text-red-500">-{{ $invoice->currency_symbol }}{{ number_format($invoice->discount, 2) }}</span>
                                    </div>
                                @endif

                                <div class="my-4 border-t border-gray-200"></div>

                                <div class="flex justify-between items-center py-2">
                                    <span class="text-base font-bold text-gray-900">{{ __('Total') }}:</span>
                                    <span
                                        class="text-xl font-black text-gray-900">{{ $invoice->currency_symbol }}{{ number_format($invoice->grand_total, 2) }}</span>
                                </div>

                                @if($invoice->amount_paid > 0)
                                    <div
                                        class="flex justify-between py-2 text-green-600 bg-green-50/50 -mx-6 px-6 mt-4 border-t border-green-100">
                                        <span class="font-medium">{{ __('Paid') }}:</span>
                                        <span
                                            class="font-bold">-{{ $invoice->currency_symbol }}{{ number_format($invoice->amount_paid, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-4 -mx-6 px-6 rounded-b-2xl border-t-2"
                                        style="background-color: {{ $invoice->amount_due <= 0 ? '#f0fdf4' : '#fef2f2' }}; border-color: {{ $invoice->amount_due <= 0 ? '#22c55e' : '#ef4444' }};">
                                        <span class="text-base font-bold"
                                            style="color: {{ $invoice->amount_due <= 0 ? '#15803d' : '#b91c1c' }};">{{ __('Balance Due') }}:</span>
                                        <span class="text-xl font-black"
                                            style="color: {{ $invoice->amount_due <= 0 ? '#15803d' : '#b91c1c' }};">{{ $invoice->currency_symbol }}{{ number_format($invoice->amount_due, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer & Signature -->
                    <div class="mt-16 pt-8 border-t border-gray-100">
                        <div class="flex flex-col md:flex-row justify-between items-end gap-8">

                            <div class="w-full md:w-1/3 text-left">
                                @if($invoice->business->bank_details)
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-xs">
                                        <div class="font-bold text-gray-700 mb-1 uppercase tracking-wider">
                                            {{ __('Bank Details') }}
                                        </div>
                                        <div class="text-gray-600 whitespace-pre-line leading-relaxed">
                                            {!! e($invoice->business->bank_details) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="w-full md:w-1/3 text-center text-gray-400 text-sm">
                                @if($template->footer_message ?? false)
                                    <p class="italic">"{{ $template->footer_message }}"</p>
                                @else
                                    <p class="italic">"{{ __('Thank you for your business!') }}"</p>
                                @endif
                            </div>

                            <div class="w-full md:w-1/3 text-right flex flex-col items-end">
                                @if($template->signature_path ?? false)
                                    <div class="inline-block text-center mt-4">
                                        <img src="{{ Storage::url($template->signature_path) }}" alt="Signature"
                                            class="max-h-16 max-w-[150px] mb-2 mx-auto"
                                            style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05));">
                                        <div
                                            class="border-t-2 border-dashed border-gray-300 pt-2 px-6 mt-1 text-xs font-semibold uppercase tracking-widest text-gray-400">
                                            {{ __('Authorized Signature') }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>

    <!-- Discussion Section -->
    <div class="max-w-2xl mx-auto mt-12 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-6 no-print">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Discussion') }}</h3>

        <div class="space-y-6 mb-8">
            @forelse(\App\Models\InvoiceComment::where('invoice_id', $invoice->id)->where('is_internal', false)->get() as $comment)
                <div class="flex space-x-3">
                    <div class="flex-1 bg-gray-50 rounded-lg px-4 py-3">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-sm font-bold text-gray-900">{{ $comment->user->name ?? __('Client') }}</h4>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-700">{{ $comment->comment }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 italic">{{ __('No comments yet. Start a discussion below.') }}</p>
            @endforelse
        </div>

        <form
            action="{{ \Illuminate\Support\Facades\URL::signedRoute('invoices.public.comment', ['invoice' => $invoice->id]) }}"
            method="POST" class="mt-6">
            @csrf
            <div>
                <label for="comment" class="sr-only">{{ __('Add a comment') }}</label>
                <textarea id="comment" name="comment" rows="3" required
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    placeholder="{{ __('Ask a question or request a change...') }}"></textarea>
            </div>
            <div class="mt-3 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Post Comment') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Platform Footer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pb-12 text-center no-print">
        <p class="text-sm text-gray-400">
            {{ __('Generated by InvoiceMaker on') }} {{ now()->format('M d, Y') }}
        </p>
    </div>
</body>

</html>