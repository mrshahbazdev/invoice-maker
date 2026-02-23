<x-landing-layout>
    <!-- Hero Section -->
    <section class="mesh-gradient relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 text-left reveal">
                    <div
                        class="inline-flex items-center space-x-2 bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-sm font-bold mb-8">
                        <span class="relative flex h-3 w-3">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                        </span>
                        <span>{{ __('Global Version 2.0 Now Live') }}</span>
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight mb-8 leading-tight text-gray-900">
                        {{ __('Invoicing that feels like') }}
                        <span class="text-blue-600">
                            {{ __('magic.') }}
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-xl">
                        {{ __('The ultimate multi-tenant SaaS platform built for the modern global entrepreneur. Professional invoices, automated cash books, and multi-currency support.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all text-center">
                            {{ __('Start For Free') }}
                        </a>
                        <a href="#features"
                            class="w-full sm:w-auto px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all text-center">
                            {{ __('See Features') }}
                        </a>
                    </div>
                </div>

                <div class="lg:w-1/2 reveal">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-blue-600/10 blur-3xl opacity-50 rounded-full"></div>
                        <img src="{{ asset('images/landing_hero_v2.png') }}" alt="InvoiceMaker V2 Dashboard"
                            class="w-full h-auto drop-shadow-2xl animate-float">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20 reveal">
                <h2 class="text-4xl font-black mb-4">{{ __('How It Works') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    {{ __('Three simple steps to professional financial management.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="reveal p-8 text-center" style="transition-delay: 100ms">
                    <div
                        class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        1</div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Create Your Profile') }}</h3>
                    <p class="text-gray-600">
                        {{ __('Setup your business identity, upload your logo, and configure your global settings in seconds.') }}
                    </p>
                </div>
                <!-- Step 2 -->
                <div class="reveal p-8 text-center" style="transition-delay: 200ms">
                    <div
                        class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        2</div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Invite Your Team') }}</h3>
                    <p class="text-gray-600">
                        {{ __('Collaborate with your partners or accountants. Manage roles and track activities in real-time.') }}
                    </p>
                </div>
                <!-- Step 3 -->
                <div class="reveal p-8 text-center" style="transition-delay: 300ms">
                    <div
                        class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        3</div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Generate & Grow') }}</h3>
                    <p class="text-gray-600">
                        {{ __('Send beautiful invoices, track every cent in the cash book, and export insights to scale your business.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Ledger (Cash Book) Highlight -->
    <section class="py-24 bg-gray-900 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 reveal">
                    <div class="glass-card p-1 rounded-3xl overflow-hidden border border-white/10">
                        <div class="bg-gray-800 p-6 flex items-center justify-between border-b border-white/5">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <span class="text-white/50 text-xs font-mono">cash-book-ledger.vhd</span>
                        </div>
                        <div class="p-8 bg-gray-950">
                            <div class="space-y-4 font-mono text-xs">
                                <div class="flex justify-between text-blue-400">
                                    <span>[ENTRY] RE-2024-001</span>
                                    <span>+€1,250.00</span>
                                </div>
                                <div class="w-full h-px bg-white/5"></div>
                                <div class="flex justify-between text-red-400">
                                    <span>[EXP] Office Supplies</span>
                                    <span>-€42.30</span>
                                </div>
                                <div class="w-full h-px bg-white/5"></div>
                                <div class="flex justify-between text-green-400">
                                    <span>[BAL] Current Ledger Balance</span>
                                    <span>€16,420.70</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 reveal">
                    <h2 class="text-4xl font-bold text-white mb-6">{{ __('Accountant-Ready Cash Book') }}</h2>
                    <p class="text-gray-400 text-lg mb-8 leading-relaxed">
                        {{ __('No more messy spreadsheets. Our professional Cash Book Ledger system automatically tracks every transaction. Double-entry style reporting that accountants love.') }}
                    </p>
                    <ul class="space-y-4 text-gray-300">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            {{ __('Unified Income & Expense Ledger') }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            {{ __('Professional Booking Numbers') }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            {{ __('One-Click Professional CSV Export') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Reach Section -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20 reveal">
                <h2 class="text-4xl font-black mb-4">{{ __('Global Scale, Local Reach') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    {{ __('Professionalism translated into the native tongues of your clients.') }}</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-8">
                @php
                    $features = [
                        ['🌐', '10 World Languages'],
                        ['💳', 'Stripe Global Payments'],
                        ['☁️', 'Multi-Tenant Cloud'],
                        ['🔒', 'SSL Secure Banking'],
                        ['📁', 'Multi-Company Support']
                    ];
                @endphp
                @foreach($features as $f)
                    <div class="reveal glass-card p-6 rounded-3xl text-center border-gray-100 group hover:shadow-2xl transition-all"
                        style="transition-delay: {{ $loop->index * 100 }}ms">
                        <div class="text-4xl mb-4 group-hover:scale-125 transition-transform duration-500">{{ $f[0] }}</div>
                        <div class="font-bold text-gray-900">{{ __($f[1]) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20 reveal">
                <h2 class="text-4xl font-black mb-4">{{ __('Simple, Transparent Pricing') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    {{ __('Start for free and scale as you grow. No hidden fees.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Free Plan -->
                <div class="reveal glass-card p-10 rounded-3xl border-gray-100 flex flex-col items-center">
                    <h3 class="text-xl font-bold mb-2">{{ __('Essential') }}</h3>
                    <div class="flex items-baseline mb-8">
                        <span class="text-4xl font-black text-gray-900">$0</span>
                        <span class="text-gray-500 ml-2">/{{ __('month') }}</span>
                    </div>
                    <ul class="space-y-4 mb-10 text-gray-600 text-sm w-full">
                        <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('Up to 10 Invoices/mo') }}</li>
                        <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('All 10 Languages') }}</li>
                        <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('Manual Cash Book') }}</li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors text-center">{{ __('Start Free') }}</a>
                </div>
                <!-- Pro Plan -->
                <div
                    class="reveal bg-white p-10 rounded-4xl border-2 border-blue-600 shadow-2xl scale-110 z-10 relative flex flex-col items-center">
                    <div
                        class="absolute -top-4 bg-blue-600 text-white text-xs font-bold px-4 py-1 rounded-full uppercase">
                        {{ __('Most Popular') }}</div>
                    <h3 class="text-xl font-bold mb-2">{{ __('Professional') }}</h3>
                    <div class="flex items-baseline mb-8">
                        <span class="text-4xl font-black text-gray-900">$19</span>
                        <span class="text-gray-500 ml-2">/{{ __('month') }}</span>
                    </div>
                    <ul class="space-y-4 mb-10 text-gray-600 text-sm w-full">
                        <li class="flex items-center"><svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('Unlimited Invoices') }}</li>
                        <li class="flex items-center"><svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('Custom SMTP Support') }}</li>
                        <li class="flex items-center"><svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('Automated Record Generation') }}</li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-xl shadow-blue-200 text-center">{{ __('Get Started Now') }}</a>
                </div>
                <!-- Enterprise Plan -->
                <div class="reveal glass-card p-10 rounded-3xl border-gray-100 flex flex-col items-center">
                    <h3 class="text-xl font-bold mb-2">{{ __('Enterprise') }}</h3>
                    <div class="flex items-baseline mb-8">
                        <span class="text-4xl font-black text-gray-900">$49</span>
                        <span class="text-gray-500 ml-2">/{{ __('month') }}</span>
                    </div>
                    <ul class="space-y-4 mb-10 text-gray-600 text-sm w-full">
                        <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('Advanced Team Analytics') }}</li>
                        <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('Dedicated Account Manager') }}</li>
                        <li class="flex items-center"><svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> {{ __('24/7 Priority Support') }}</li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors text-center">{{ __('Contact Sales') }}</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-24 bg-blue-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100" stroke="white" fill="transparent" />
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal">
            <h2 class="text-4xl text-white font-bold mb-8">{{ __('Ready to simplify your business?') }}</h2>
            <a href="{{ route('register') }}"
                class="inline-block px-10 py-5 bg-white text-blue-600 font-extrabold rounded-2xl hover:scale-105 transition-all shadow-xl">
                {{ __('Create Your Account Now') }}
            </a>
        </div>
    </section>
</x-landing-layout>