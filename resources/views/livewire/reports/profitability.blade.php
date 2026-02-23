@php $title = __('Profitability Report'); @endphp

<div class="space-y-8">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ __('Profitability Report') }}</h2>
            <p class="text-gray-600 text-lg font-medium">
                {{ __('Analyze which customers and products drive your growth.') }}
            </p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-6">
            <!-- Advanced Filters Label -->
            <div class="hidden xl:block">
                <span
                    class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Advanced Filters') }}</span>
            </div>

            <!-- Unified Search -->
            <div class="relative w-full md:w-80 group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search client or product...') }}" </div>

                <!-- Date Range -->
                <div
                    class="flex items-center gap-4 bg-white px-5 py-3 rounded-2xl shadow-sm border-2 border-gray-100 w-full md:w-auto">
                    <div class="flex flex-col">
                        <span
                            class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ __('From') }}</span>
                        <input type="date" wire:model.live="startDate"
                            class="border-none focus:ring-0 text-sm font-bold text-gray-800 p-0">
                    </div>
                    <span class="text-gray-300 font-bold">→</span>
                    <div class="flex flex-col">
                        <span
                            class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ __('To') }}</span>
                        <input type="date" wire:model.live="endDate"
                            class="border-none focus:ring-0 text-sm font-bold text-gray-800 p-0">
                    </div>
                </div>

                <!-- Export Button -->
                <a href="{{ route('reports.profitability.export', ['startDate' => $startDate, 'endDate' => $endDate]) }}"
                    class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-2xl font-bold hover:bg-green-700 shadow-lg shadow-green-100 transition-all text-sm w-full md:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ __('Export evaluation to Excel') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div
            class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center group hover:shadow-lg transition-all duration-300">
            <div
                class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ __('Total Revenue') }}</span>
                <p class="text-3xl font-extrabold text-gray-900 leading-none mt-2">
                    {{ number_format($totalRevenue, 2, '.', ',') }} €
                </p>
            </div>
        </div>

        <div
            class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center group hover:shadow-lg transition-all duration-300">
            <div
                class="w-16 h-16 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 group-hover:bg-red-600 group-hover:text-white transition-all duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span
                    class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ __('Total Expenses') }}</span>
                <p class="text-3xl font-extrabold text-red-600 leading-none mt-2">
                    {{ number_format($totalExpenses, 2, '.', ',') }} €
                </p>
            </div>
        </div>

        <div
            class="bg-gray-900 p-8 rounded-3xl shadow-2xl flex items-center relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-24 h-24" fill="white" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
                    </path>
                </svg>
            </div>
            <div
                class="w-16 h-16 bg-white/10 text-white rounded-2xl flex items-center justify-center mr-6 backdrop-blur-md group-hover:bg-white group-hover:text-gray-900 transition-all duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3m0 10c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8m0-18C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z">
                    </path>
                </svg>
            </div>
            <div class="relative z-10">
                <span class="text-xs font-bold text-blue-400 uppercase tracking-widest">{{ __('Net Profit') }}</span>
                <p class="text-3xl font-extrabold text-white leading-none mt-2">
                    {{ number_format($netIncome, 2, '.', ',') }}
                    €
                </p>
            </div>
        </div>
    </div>

    <!-- Top Performers Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Top Clients -->
        <div class="bg-blue-50/50 rounded-3xl p-6 border border-blue-100/50">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-xs font-black text-blue-600 uppercase tracking-widest">
                    {{ __('Top Profit Drivers: Clients') }}
                </h4>
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="space-y-3">
                @forelse($topClients as $client)
                    <div
                        class="bg-white px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm border border-blue-50">
                        <div class="flex items-center gap-3">
                            <span
                                class="w-6 h-6 rounded-full bg-blue-600 text-white text-[10px] flex items-center justify-center font-bold">{{ $loop->iteration }}</span>
                            <span class="text-sm font-bold text-gray-800">{{ $client['name'] }}</span>
                        </div>
                        <span class="text-sm font-black text-blue-600">+
                            {{ number_format($client['difference'], 2, '.', ',') }} €</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 font-medium italic">
                        {{ __('No data available for the selected range.') }}
                    </p>
                @endforelse
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-indigo-50/50 rounded-3xl p-6 border border-indigo-100/50">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-xs font-black text-indigo-600 uppercase tracking-widest">
                    {{ __('Top Profit Drivers: Products') }}
                </h4>
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="space-y-3">
                @forelse($topProducts as $product)
                    <div
                        class="bg-white px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm border border-indigo-50">
                        <div class="flex items-center gap-3">
                            <span
                                class="w-6 h-6 rounded-full bg-indigo-600 text-white text-[10px] flex items-center justify-center font-bold">{{ $loop->iteration }}</span>
                            <span class="text-sm font-bold text-gray-800">{{ $product['name'] }}</span>
                        </div>
                        <span class="text-sm font-black text-indigo-600">+
                            {{ number_format($product['difference'], 2, '.', ',') }} €</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 font-medium italic">
                        {{ __('No data available for the selected range.') }}
                    </p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
        <!-- Client ROI -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-8 bg-blue-600 rounded-full"></div>
                    <h3 class="text-xl font-extrabold text-gray-900 uppercase tracking-tight">{{ __('Client ROI') }}
                    </h3>
                </div>
                <span
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-white px-3 py-1 rounded-full border border-gray-100">{{ __('Revenue vs Direct Costs') }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Client') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Sales') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Costs') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Difference') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Performance') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($clientProfitability as $client)
                            <tr class="hover:bg-blue-50/30 transition-all duration-200 group">
                                <td class="px-8 py-6">
                                    <span
                                        class="block text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $client['name'] }}</span>
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-gray-600 text-base">
                                    {{ number_format($client['sales'], 2, '.', ',') }} €
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-red-500 text-base">
                                    {{ number_format($client['costs'], 2, '.', ',') }} €
                                </td>
                                <td
                                    class="px-8 py-6 text-right font-extrabold text-base {{ $client['difference'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($client['difference'], 2, '.', ',') }} €
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex flex-col items-end gap-1">
                                        @if($client['margin'] > 30)
                                            <span
                                                class="px-3 py-1 rounded-lg text-[10px] font-black bg-green-600 text-white uppercase tracking-wider shadow-sm shadow-green-200">{{ __('KEEP') }}</span>
                                        @elseif($client['margin'] > 10)
                                            <span
                                                class="px-3 py-1 rounded-lg text-[10px] font-black bg-orange-500 text-white uppercase tracking-wider shadow-sm shadow-orange-200">{{ __('OPTIMIZE') }}</span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-lg text-[10px] font-black bg-red-600 text-white uppercase tracking-wider shadow-sm shadow-red-200">{{ __('REVIEW') }}</span>
                                        @endif
                                        <span
                                            class="text-xs font-black text-gray-400 font-mono mt-1">{{ number_format($client['margin'], 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Product Margins -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-8 bg-indigo-600 rounded-full"></div>
                    <h3 class="text-xl font-extrabold text-gray-900 uppercase tracking-tight">
                        {{ __('Product Margins') }}
                    </h3>
                </div>
                <span
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-white px-3 py-1 rounded-full border border-gray-100">{{ __('Sales vs Purchase Cost') }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Product') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Sales') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Costs') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Difference') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                {{ __('Performance') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($productProfitability as $product)
                            <tr class="hover:bg-indigo-50/30 transition-all duration-200 group">
                                <td class="px-8 py-6">
                                    <span
                                        class="block text-base font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $product['name'] }}</span>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-600 mt-1 uppercase">
                                        {{ $product['sold'] }} {{ __('sold') }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-gray-600 text-base">
                                    {{ number_format($product['sales'], 2, '.', ',') }} €
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-red-500 text-base">
                                    {{ number_format($product['costs'], 2, '.', ',') }} €
                                </td>
                                <td
                                    class="px-8 py-6 text-right font-extrabold text-base {{ $product['difference'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($product['difference'], 2, '.', ',') }} €
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex flex-col items-end gap-1">
                                        @if($product['margin'] > 30)
                                            <span
                                                class="px-3 py-1 rounded-lg text-[10px] font-black bg-green-600 text-white uppercase tracking-wider shadow-sm shadow-green-200">{{ __('KEEP') }}</span>
                                        @elseif($product['margin'] > 10)
                                            <span
                                                class="px-3 py-1 rounded-lg text-[10px] font-black bg-orange-500 text-white uppercase tracking-wider shadow-sm shadow-orange-200">{{ __('OPTIMIZE') }}</span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-lg text-[10px] font-black bg-red-600 text-white uppercase tracking-wider shadow-sm shadow-red-200">{{ __('REVIEW') }}</span>
                                        @endif
                                        <span
                                            class="text-xs font-black text-gray-400 font-mono mt-1">{{ number_format($product['margin'], 1) }}%</span>
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
</div>