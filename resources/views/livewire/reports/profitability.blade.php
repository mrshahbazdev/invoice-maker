@php $title = __('Profitability & Revenue Benchmarks'); @endphp

<div class="space-y-8">
    <!-- Header & Period Filter Bar -->
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 border-b border-gray-100 pb-8">
        <div>
            <h2 class="text-3xl font-bold text-txmain tracking-tight">{{ __('Profitability & Break-Even Analysis') }}</h2>
            <p class="text-gray-500 text-base">
                {{ __('Track fixed & variable costs, evaluate monthly benchmarks, and monitor revenue requirements.') }}
            </p>
        </div>

        <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-4">
            <!-- Unified Search -->
            <div class="relative w-full lg:w-64 group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-brand-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search client or product...') }}"
                    class="w-full pl-10 pr-3 py-2 bg-card border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 text-sm font-medium transition-all outline-none">
            </div>

            <!-- Export Button -->
            <a href="{{ route('reports.profitability.export', ['startDate' => $startDate, 'endDate' => $endDate]) }}"
                class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition-all text-sm justify-center shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('Export') }}
            </a>
        </div>
    </div>

    <!-- Time Period Preset Selector -->
    <div class="bg-card p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Preset Buttons -->
        <div class="flex items-center flex-wrap gap-2 w-full md:w-auto">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-1">{{ __('Period') }}:</span>
            
            <button type="button" wire:click="setPeriod('this_month')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $period === 'this_month' ? 'bg-brand-600 text-white shadow-sm' : 'bg-page text-txmain hover:bg-gray-100' }}">
                {{ __('This Month') }}
            </button>

            <button type="button" wire:click="setPeriod('last_month')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $period === 'last_month' ? 'bg-brand-600 text-white shadow-sm' : 'bg-page text-txmain hover:bg-gray-100' }}">
                {{ __('Past Month') }}
            </button>

            <button type="button" wire:click="setPeriod('last_3_months')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $period === 'last_3_months' ? 'bg-brand-600 text-white shadow-sm' : 'bg-page text-txmain hover:bg-gray-100' }}">
                {{ __('Past 3 Months') }}
            </button>

            <button type="button" wire:click="setPeriod('last_6_months')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $period === 'last_6_months' ? 'bg-brand-600 text-white shadow-sm' : 'bg-page text-txmain hover:bg-gray-100' }}">
                {{ __('Last Half-Year (6M)') }}
            </button>

            <button type="button" wire:click="setPeriod('last_year')"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $period === 'last_year' ? 'bg-brand-600 text-white shadow-sm' : 'bg-page text-txmain hover:bg-gray-100' }}">
                {{ __('Full Year (12M)') }}
            </button>
        </div>

        <!-- Custom Date Range Pickers -->
        <div class="flex items-center gap-2 bg-page px-3 py-1.5 rounded-xl border border-gray-200/80 w-full md:w-auto justify-between md:justify-start">
            <div class="flex flex-col">
                <span class="text-[8px] font-black text-gray-400 uppercase">{{ __('From') }}</span>
                <input type="date" wire:model.live="startDate" class="bg-transparent border-none focus:ring-0 text-xs font-bold text-txmain p-0">
            </div>
            <span class="text-gray-300 font-bold px-1">→</span>
            <div class="flex flex-col">
                <span class="text-[8px] font-black text-gray-400 uppercase">{{ __('To') }}</span>
                <input type="date" wire:model.live="endDate" class="bg-transparent border-none focus:ring-0 text-xs font-bold text-txmain p-0">
            </div>
        </div>
    </div>

    <!-- Benchmark KPI & Current Trend Alert Card -->
    <div class="bg-gradient-to-br from-card via-card to-page p-6 rounded-3xl border {{ $gapToBenchmark >= 0 ? 'border-emerald-200/80' : 'border-amber-200/80' }} shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ $gapToBenchmark >= 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $gapToBenchmark >= 0 ? __('✓ Benchmark Achieved') : __('⚠️ Revenue Below Benchmark') }}
                    </span>
                    <span class="text-xs text-gray-400 font-medium">
                        ({{ $monthsCount }} {{ $monthsCount == 1 ? __('Month') : __('Months') }} {{ __('analyzed') }})
                    </span>
                </div>
                <h3 class="text-xl font-bold text-txmain">
                    @if($gapToBenchmark >= 0)
                        {{ __('Fixed Cost Obligations are 100% Covered with') }} <span class="text-emerald-600">+{{ number_format($gapToBenchmark, 2, '.', ',') }} €</span> {{ __('Surplus') }}
                    @else
                        <span class="text-amber-600">{{ number_format(abs($gapToBenchmark), 2, '.', ',') }} €</span> {{ __('more revenue needed to cover fixed overheads.') }}
                    @endif
                </h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ __('Absolute Minimum Revenue Benchmark to break even on fixed costs:') }} 
                    <strong class="text-txmain font-mono">{{ number_format($monthlyBenchmark, 2, '.', ',') }} € / {{ __('month') }}</strong> 
                    ({{ __('Total Period Target') }}: <span class="font-mono">{{ number_format($fixedCosts, 2, '.', ',') }} €</span>).
                </p>
            </div>

            <!-- Progress Meter -->
            <div class="lg:w-80 space-y-2 bg-page p-4 rounded-2xl border border-gray-100">
                <div class="flex justify-between text-xs font-bold">
                    <span class="text-gray-500">{{ __('Fixed Cost Coverage') }}</span>
                    <span class="{{ $coveragePercent >= 100 ? 'text-emerald-600' : 'text-amber-600' }} font-mono">{{ $coveragePercent }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div class="h-3 rounded-full transition-all duration-500 {{ $coveragePercent >= 100 ? 'bg-emerald-500' : 'bg-amber-500' }}"
                        style="width: {{ min(100, $coveragePercent) }}%"></div>
                </div>
                <div class="flex justify-between text-[10px] text-gray-400">
                    <span>0 €</span>
                    <span>{{ __('Target') }}: {{ number_format($fixedCosts, 2, '.', ',') }} €</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Revenue -->
        <div class="bg-card p-5 rounded-2xl border border-gray-100 flex items-center group transition-all duration-300 shadow-sm hover:border-brand-200 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-1 pt-12 h-full bg-brand-500"></div>
            <div class="w-10 h-10 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center mr-3 group-hover:bg-brand-600 group-hover:text-white transition-all duration-300 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block truncate">{{ __('Total Revenue') }}</span>
                <p class="text-xl font-bold text-txmain mt-0.5 truncate">
                    {{ number_format($totalRevenue, 2, '.', ',') }} €
                </p>
            </div>
        </div>

        <!-- Fixed Costs (F) -->
        <div class="bg-card p-5 rounded-2xl border border-amber-100/60 flex items-center group transition-all duration-300 shadow-sm hover:border-amber-300 relative overflow-hidden bg-amber-50/10">
            <div class="absolute right-0 top-0 w-1 pt-12 h-full bg-amber-500"></div>
            <div class="w-10 h-10 bg-amber-100/80 text-amber-700 rounded-xl flex items-center justify-center mr-3 font-black text-sm group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 shrink-0">
                F
            </div>
            <div class="min-w-0">
                <span class="text-[10px] font-bold text-amber-700/80 uppercase tracking-widest block truncate">{{ __('Fixed Costs [F]') }}</span>
                <p class="text-xl font-bold text-amber-700 mt-0.5 truncate" title="{{ __('Fixkosten') }}">
                    {{ number_format($fixedCosts, 2, '.', ',') }} €
                </p>
            </div>
        </div>

        <!-- Variable Costs (V) -->
        <div class="bg-card p-5 rounded-2xl border border-blue-100/60 flex items-center group transition-all duration-300 shadow-sm hover:border-blue-300 relative overflow-hidden bg-blue-50/10">
            <div class="absolute right-0 top-0 w-1 pt-12 h-full bg-blue-500"></div>
            <div class="w-10 h-10 bg-blue-100/80 text-blue-700 rounded-xl flex items-center justify-center mr-3 font-black text-sm group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shrink-0">
                V
            </div>
            <div class="min-w-0">
                <span class="text-[10px] font-bold text-blue-700/80 uppercase tracking-widest block truncate">{{ __('Variable Costs [V]') }}</span>
                <p class="text-xl font-bold text-blue-700 mt-0.5 truncate" title="{{ __('Variable Kosten') }}">
                    {{ number_format($variableCosts, 2, '.', ',') }} €
                </p>
            </div>
        </div>

        <!-- Sales Requirement / Break-Even threshold -->
        <div class="bg-card p-5 rounded-2xl border border-purple-100/60 flex items-center group transition-all duration-300 shadow-sm hover:border-purple-300 relative overflow-hidden bg-purple-50/10">
            <div class="absolute right-0 top-0 w-1 pt-12 h-full bg-purple-500"></div>
            <div class="w-10 h-10 bg-purple-100/80 text-purple-700 rounded-xl flex items-center justify-center mr-3 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] font-bold text-purple-700/80 uppercase tracking-widest block truncate">{{ __('Sales Req. (Fixed)') }}</span>
                <p class="text-xl font-bold text-purple-700 mt-0.5 truncate" title="{{ __('Minimum Sales to cover Fixed Costs (∑F)') }}">
                    {{ number_format($salesRequirement, 2, '.', ',') }} €
                </p>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="bg-card p-5 rounded-2xl border border-gray-100 flex items-center group transition-all duration-300 shadow-sm hover:border-emerald-200 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-1 pt-12 h-full {{ $netIncome >= 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
            <div class="w-10 h-10 {{ $netIncome >= 0 ? 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600' : 'bg-red-50 text-red-600 group-hover:bg-red-600' }} rounded-xl flex items-center justify-center mr-3 group-hover:text-white transition-all duration-300 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3m0 10c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8m0-18C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z">
                    </path>
                </svg>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block truncate">{{ __('Net Profit') }}</span>
                <p class="text-xl font-bold {{ $netIncome >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-0.5 truncate">
                    {{ number_format($netIncome, 2, '.', ',') }} €
                </p>
            </div>
        </div>
    </div>

    <!-- Monthly Averages & Baseline Benchmarks Section -->
    <div class="bg-card rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
            <div>
                <h3 class="text-base font-bold text-txmain">{{ __('Monthly Averages & Cost Baseline') }}</h3>
                <p class="text-xs text-gray-400">
                    {{ __('Calculated monthly average metrics across the selected') }} {{ $monthsCount }} {{ __('month(s)') }}.
                </p>
            </div>
            <span class="px-3 py-1 rounded-lg bg-page text-txmain text-xs font-bold font-mono">
                {{ $monthsCount }}M {{ __('Average') }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Avg Monthly Revenue -->
            <div class="p-4 bg-page rounded-xl border border-gray-100">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">{{ __('Avg. Revenue / Month') }}</span>
                <p class="text-lg font-bold text-txmain mt-1">{{ number_format($avgMonthlyRevenue, 2, '.', ',') }} €</p>
                <span class="text-[10px] text-gray-400">{{ __('Monthly run-rate') }}</span>
            </div>

            <!-- Avg Monthly Fixed Costs (Benchmark) -->
            <div class="p-4 bg-amber-50/30 rounded-xl border border-amber-200/60">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block">{{ __('Avg. Fixed Cost [F]') }}</span>
                    <span class="text-[9px] font-black uppercase px-1.5 py-0.5 rounded bg-amber-100 text-amber-800">{{ __('Benchmark') }}</span>
                </div>
                <p class="text-lg font-bold text-amber-800 mt-1">{{ number_format($avgMonthlyFixedCosts, 2, '.', ',') }} €</p>
                <span class="text-[10px] text-amber-700/80">{{ __('Min. monthly revenue to break-even') }}</span>
            </div>

            <!-- Avg Monthly Variable Costs -->
            <div class="p-4 bg-blue-50/30 rounded-xl border border-blue-200/60">
                <span class="text-[10px] font-bold text-blue-800 uppercase tracking-wider block">{{ __('Avg. Variable Cost [V]') }}</span>
                <p class="text-lg font-bold text-blue-800 mt-1">{{ number_format($avgMonthlyVariableCosts, 2, '.', ',') }} €</p>
                <span class="text-[10px] text-blue-700/80">{{ __('Monthly variable spend') }}</span>
            </div>

            <!-- Avg Monthly Net Profit -->
            <div class="p-4 bg-page rounded-xl border border-gray-100">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">{{ __('Avg. Net Profit / Month') }}</span>
                <p class="text-lg font-bold {{ $avgMonthlyNetProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-1">
                    {{ number_format($avgMonthlyNetProfit, 2, '.', ',') }} €
                </p>
                <span class="text-[10px] text-gray-400">{{ __('Monthly bottom line') }}</span>
            </div>
        </div>
    </div>

    <!-- Top Performers Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Top Clients -->
        <div class="bg-brand-50/50 rounded-2xl p-5 border border-brand-100/50">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-[10px] font-bold text-brand-600 uppercase tracking-widest">
                    {{ __('Top Profit Drivers: Clients') }}
                </h4>
            </div>
            <div class="space-y-2">
                @forelse($topClients as $client)
                    <div class="bg-card px-4 py-2.5 rounded-xl flex items-center justify-between shadow-sm border border-brand-50/50">
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded bg-brand-600 text-white text-[9px] flex items-center justify-center font-bold">{{ $loop->iteration }}</span>
                            <span class="text-sm font-semibold text-txmain">{{ $client['name'] }}</span>
                        </div>
                        <span class="text-sm font-bold text-brand-600">+ {{ number_format($client['difference'], 2, '.', ',') }} €</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 font-medium italic">{{ __('No data available for the selected range.') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-brand-50/50 rounded-2xl p-5 border border-brand-100/50">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-[10px] font-bold text-brand-600 uppercase tracking-widest">
                    {{ __('Top Profit Drivers: Products') }}
                </h4>
            </div>
            <div class="space-y-2">
                @forelse($topProducts as $product)
                    <div class="bg-card px-4 py-2.5 rounded-xl flex items-center justify-between shadow-sm border border-brand-50/50">
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded bg-brand-600 text-white text-[9px] flex items-center justify-center font-bold">{{ $loop->iteration }}</span>
                            <span class="text-sm font-semibold text-txmain">{{ $product['name'] }}</span>
                        </div>
                        <span class="text-sm font-bold text-brand-600">+ {{ number_format($product['difference'], 2, '.', ',') }} €</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 font-medium italic">{{ __('No data available for the selected range.') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Client and Product Tables -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Client ROI Table -->
        <div class="bg-card rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-page/50">
                <h3 class="text-sm font-bold text-txmain uppercase tracking-wider">{{ __('Client Performance') }}</h3>
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Invoiced vs Direct Costs') }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-page/50 border-b border-gray-100">
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Client') }}</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Sales') }}</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Costs') }}</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Performance') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($clientProfitability as $item)
                            <tr class="hover:bg-page/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-txmain">{{ $item['name'] }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-right text-txmain">{{ number_format($item['sales'], 2, '.', ',') }} €</td>
                                <td class="px-6 py-4 text-sm text-right text-red-600">-{{ number_format($item['costs'], 2, '.', ',') }} €</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold {{ $item['difference'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ $item['difference'] >= 0 ? '+' : '' }}{{ number_format($item['difference'], 2, '.', ',') }} €
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-xs text-gray-400 italic">{{ __('No client data available.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Product Profitability Table -->
        <div class="bg-card rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-page/50">
                <h3 class="text-sm font-bold text-txmain uppercase tracking-wider">{{ __('Product Profitability') }}</h3>
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Sales vs Purchase Cost') }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-page/50 border-b border-gray-100">
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Product / Service') }}</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Sold') }}</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Revenue') }}</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ __('Profit') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($productProfitability as $product)
                            <tr class="hover:bg-page/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-txmain">{{ $product['name'] }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-500">{{ $product['sold'] }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-right text-txmain">{{ number_format($product['sales'], 2, '.', ',') }} €</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold {{ $product['difference'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ $product['difference'] >= 0 ? '+' : '' }}{{ number_format($product['difference'], 2, '.', ',') }} €
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-xs text-gray-400 italic">{{ __('No product data available.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>