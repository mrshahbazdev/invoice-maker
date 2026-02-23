@php $title = __('Profitability Report'); @endphp

<div class="space-y-8">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Profitability Report') }}</h2>
            <p class="text-gray-500 font-medium">{{ __('Analyze which customers and products drive your growth.') }}</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4">
            <!-- Unified Search -->
            <div class="relative w-full sm:w-64 group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search client or product...') }}"
                    class="block w-full pl-11 pr-4 py-3 bg-white border-gray-100 rounded-2xl text-sm font-bold text-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500/20 transition-all">
            </div>

            <!-- Date Range -->
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100">
                <input type="date" wire:model.live="startDate"
                    class="border-none focus:ring-0 text-xs font-black text-gray-700 p-0">
                <span class="text-gray-300 font-bold">→</span>
                <input type="date" wire:model.live="endDate"
                    class="border-none focus:ring-0 text-xs font-black text-gray-700 p-0">
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center group hover:shadow-md transition-shadow">
            <div
                class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <span
                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ __('Total Revenue') }}</span>
                <p class="text-2xl font-black text-gray-900 leading-none mt-1">
                    {{ number_format($totalRevenue, 2, ',', '.') }} €
                </p>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center group hover:shadow-md transition-shadow">
            <div
                class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span
                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ __('Total Expenses') }}</span>
                <p class="text-2xl font-black text-red-600 leading-none mt-1">
                    {{ number_format($totalExpenses, 2, ',', '.') }} €
                </p>
            </div>
        </div>

        <div class="bg-gray-900 p-6 rounded-2xl shadow-lg flex items-center relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-3 opacity-10">
                <svg class="w-16 h-16" fill="white" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
                    </path>
                </svg>
            </div>
            <div
                class="w-12 h-12 bg-white/10 text-white rounded-xl flex items-center justify-center mr-4 backdrop-blur-md group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3m0 10c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8m0-18C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z">
                    </path>
                </svg>
            </div>
            <div class="relative z-10">
                <span
                    class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em]">{{ __('Net Profit') }}</span>
                <p class="text-2xl font-black text-white leading-none mt-1">{{ number_format($netIncome, 2, ',', '.') }}
                    €</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <!-- Client ROI -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                <h3 class="text-lg font-black text-gray-900">{{ __('Client ROI') }}</h3>
                <span
                    class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Revenue vs Direct Costs') }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="px-6 py-3">{{ __('Client') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Sales') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Costs') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Difference') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Performance') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($clientProfitability as $client)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span
                                        class="block text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $client['name'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-600 text-sm">
                                    {{ number_format($client['sales'], 2, ',', '.') }} €
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-red-500 text-sm">
                                    {{ number_format($client['costs'], 2, ',', '.') }} €
                                </td>
                                <td
                                    class="px-6 py-4 text-right font-black text-sm {{ $client['difference'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($client['difference'], 2, ',', '.') }} €
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex flex-col items-end">
                                        @if($client['margin'] > 30)
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] font-black bg-green-500 text-white uppercase tracking-tighter">{{ __('KEEP') }}</span>
                                        @elseif($client['margin'] > 10)
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] font-black bg-orange-400 text-white uppercase tracking-tighter">{{ __('OPTIMIZE') }}</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] font-black bg-red-500 text-white uppercase tracking-tighter">{{ __('REVIEW') }}</span>
                                        @endif
                                        <span
                                            class="text-[10px] font-bold text-gray-400 font-mono mt-0.5">{{ number_format($client['margin'], 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Product Margins -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                <h3 class="text-lg font-black text-gray-900">{{ __('Product Margins') }}</h3>
                <span
                    class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Sales vs Purchase Cost') }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="px-6 py-3">{{ __('Product') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Sales') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Costs') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Difference') }}</th>
                            <th class="px-6 py-3 text-right">{{ __('Performance') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($productProfitability as $product)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span
                                        class="block text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $product['name'] }}</span>
                                    <span class="block text-[10px] text-gray-400 font-medium">{{ $product['sold'] }}
                                        {{ __('sold') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-600 text-sm">
                                    {{ number_format($product['sales'], 2, ',', '.') }} €
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-red-500 text-sm">
                                    {{ number_format($product['costs'], 2, ',', '.') }} €
                                </td>
                                <td
                                    class="px-6 py-4 text-right font-black text-sm {{ $product['difference'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($product['difference'], 2, ',', '.') }} €
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex flex-col items-end">
                                        @if($product['margin'] > 30)
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] font-black bg-green-500 text-white uppercase tracking-tighter">{{ __('KEEP') }}</span>
                                        @elseif($product['margin'] > 10)
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] font-black bg-orange-400 text-white uppercase tracking-tighter">{{ __('OPTIMIZE') }}</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] font-black bg-red-500 text-white uppercase tracking-tighter">{{ __('REVIEW') }}</span>
                                        @endif
                                        <span
                                            class="text-[10px] font-bold text-gray-400 font-mono mt-0.5">{{ number_format($product['margin'], 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>