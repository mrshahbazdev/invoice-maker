@php $title = __('Profitability Report'); @endphp

<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Profitability Report') }}</h2>
            <p class="text-gray-500 font-medium">{{ __('Analyze which customers and products drive your growth.') }}</p>
        </div>

        <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
            <input type="date" wire:model.live="startDate"
                class="border-none focus:ring-0 text-sm font-bold text-gray-700">
            <span class="text-gray-300">→</span>
            <input type="date" wire:model.live="endDate"
                class="border-none focus:ring-0 text-sm font-bold text-gray-700">
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white p-8 rounded-[2rem] shadow-xl shadow-blue-900/5 border border-gray-100 flex items-center group">
            <div
                class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <span
                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ __('Total Revenue') }}</span>
                <p class="text-3xl font-black text-gray-900 leading-none mt-2">
                    {{ number_format($totalRevenue, 2, ',', '.') }} €
                </p>
            </div>
        </div>

        <div
            class="bg-white p-8 rounded-[2rem] shadow-xl shadow-blue-900/5 border border-gray-100 flex items-center group">
            <div
                class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span
                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ __('Total Expenses') }}</span>
                <p class="text-3xl font-black text-red-600 leading-none mt-2">
                    {{ number_format($totalExpenses, 2, ',', '.') }} €
                </p>
            </div>
        </div>

        <div class="bg-gray-900 p-8 rounded-[2rem] shadow-2xl flex items-center relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-24 h-24" fill="white" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
                    </path>
                </svg>
            </div>
            <div
                class="w-14 h-14 bg-white/10 text-white rounded-2xl flex items-center justify-center mr-6 backdrop-blur-md group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3m0 10c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8m0-18C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z">
                    </path>
                </svg>
            </div>
            <div class="relative z-10">
                <span
                    class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em]">{{ __('Net Profit') }}</span>
                <p class="text-3xl font-black text-white leading-none mt-2">{{ number_format($netIncome, 2, ',', '.') }}
                    €</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Client ROI -->
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-xl font-black text-gray-900">{{ __('Client ROI') }}</h3>
                <span
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Revenue vs Direct Costs') }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="px-8 py-4">{{ __('Client') }}</th>
                            <th class="px-8 py-4 text-right">{{ __('Net Profit') }}</th>
                            <th class="px-8 py-4 text-right">{{ __('Margin') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($clientProfitability as $client)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="block text-sm font-bold text-gray-900">{{ $client['name'] }}</span>
                                    <span class="block text-[10px] text-gray-400">{{ __('Rev:') }}
                                        {{ number_format($client['revenue'], 2, ',', '.') }} €</span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-gray-900">
                                    {{ number_format($client['profit'], 2, ',', '.') }} €
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-black {{ $client['margin'] > 20 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ number_format($client['margin'], 1) }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Product Margins -->
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-xl font-black text-gray-900">{{ __('Product Margins') }}</h3>
                <span
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Sales vs Purchase Cost') }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="px-8 py-4">{{ __('Product') }}</th>
                            <th class="px-8 py-4 text-right">{{ __('Profit') }}</th>
                            <th class="px-8 py-4 text-right">{{ __('Margin') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($productProfitability as $product)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="block text-sm font-bold text-gray-900">{{ $product['name'] }}</span>
                                    <span class="block text-[10px] text-gray-400">{{ $product['sold'] }}
                                        {{ __('sold') }}</span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-gray-900">
                                    {{ number_format($product['profit'], 2, ',', '.') }} €
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-black {{ $product['margin'] > 30 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ number_format($product['margin'], 1) }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>