<!-- Mobile backdrop -->
<div x-show="mobileMenuOpen" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click="mobileMenuOpen = false"
    class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden" style="display: none;">
</div>

<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white/80 backdrop-blur-xl border-r border-gray-200/50 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transition-transform duration-300"
    :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    @click.away="mobileMenuOpen = false">
    <!-- Mobile close button -->
    <div class="absolute right-4 top-4 lg:hidden">
        <button @click="mobileMenuOpen = false" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <div class="flex flex-col h-full">
        <div class="flex items-center justify-center h-20 border-b border-gray-200/50">
            @if($logo = \App\Models\Setting::get('site.logo'))
                <img src="{{ Storage::url($logo) }}" alt="Logo" class="max-h-12 max-w-[80%] object-contain">
            @else
                <span
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-brand-600 tracking-tight">{{ \App\Models\Setting::get('site.name', config('app.name')) }}</span>
            @endif
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            @if(auth()->user()->business_id)
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    {{ __('Dashboard') }}
                </a>

                @if(auth()->user()->isOwner())
                    <a href="{{ route('business.profile') }}"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('business.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        {{ __('Business Profile') }}
                    </a>
                @endif

                <a href="{{ route('clients.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('clients.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    {{ __('Clients') }}
                </a>

                <a href="{{ route('products.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('products.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    {{ __('Products') }}
                </a>

                <a href="{{ route('invoices.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('invoices.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    {{ __('Invoices') }}
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('settings.team') }}" wire:navigate
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('settings.team') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        {{ __('Team') }}
                    </a>
                @endif

                <a href="{{ route('estimates.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('estimates.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    {{ __('Estimates') }}
                </a>

                <a href="{{ route('templates.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('templates.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                        </path>
                    </svg>
                    {{ __('Templates') }}
                </a>

                <a href="{{ route('expenses.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('expenses.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    {{ __('Expenses') }}
                </a>

                <a href="{{ route('expenses.categories') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('expenses.categories') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                        </path>
                    </svg>
                    {{ __('Expense Categories') }}
                </a>

                <a href="{{ route('accounting.cash-book') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('accounting.cash-book') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    {{ __('Cash Book') }}
                </a>

                <a href="{{ route('reports.profitability') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('reports.profitability') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    {{ __('Profitability') }}
                </a>
            @else
                <a href="{{ route('client.dashboard') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('client.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    {{ __('My Invoices') }}
                </a>
            @endif
        </nav>

        @if(auth()->user()->business_id)
            <div class="p-4 border-t border-gray-200/50 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <p class="font-bold text-gray-900 truncate w-32">
                            {{ auth()->user()->business->name ?? __('Business Name') }}
                        </p>
                        @if(auth()->user()->isOwner())
                            <a href="{{ route('business.profile') }}"
                                class="text-gray-400 hover:text-blue-600 transition-colors" title="{{ __('Settings') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 mt-0.5">
                        {{ auth()->user()->business->currency ?? 'USD' }}
                    </p>
                    <span
                        class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-brand-700 bg-brand-100/80 rounded-full border border-brand-200">
                        {{ auth()->user()->business->plan ?? 'FREE' }}
                    </span>
                </div>
                @if((auth()->user()->business->plan ?? 'free') === 'free')
                    <div class="mt-3">
                        <button
                            class="w-full py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-blue-600 to-brand-600 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            {{ __('Upgrade to PRO') }} 🚀
                        </button>
                    </div>
                @endif
            </div>
        @else
            <div class="p-4 border-t border-gray-200/50 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <p class="font-bold text-gray-900 truncate w-32">{{ __('Client Portal') }}</p>
                    </div>
                    <span
                        class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-green-700 bg-green-100/80 rounded-full border border-green-200">
                        CLIENT
                    </span>
                </div>
            </div>
        @endif
    </div>
</aside>