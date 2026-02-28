<x-landing-layout>
    <!-- Hero Section -->
    <section class="mesh-gradient relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Floating decorative elements -->
        <div class="absolute top-1/4 -left-20 w-64 h-64 bg-brand-400/20 blur-[100px] rounded-full animate-float"></div>
        <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-brand-400/20 blur-[120px] rounded-full animate-float"
            style="animation-delay: 2s"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 text-left reveal">
                    <div
                        class="inline-flex items-center space-x-2 bg-card/80 backdrop-blur-md border border-brand-100 text-brand-600 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest mb-8 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-600"></span>
                        </span>
                        <span>{{ __('V2.1 Enterprise Ready') }}</span>
                    </div>
                    <h1 class="text-6xl lg:text-8xl font-black tracking-tighter mb-8 leading-[0.9] text-txmain">
                        {{ __('Invoicing') }}<br />
                        <span class="text-brand-600">
                            {{ __('Perfected.') }}
                        </span>
                    </h1>
                    <p class="text-xl text-gray-500 mb-10 leading-relaxed max-w-xl font-medium">
                        {{ __('The ultimate multi-tenant SaaS platform built for modern global entrepreneurs. Professional invoices, job profitability tracking, and accountant-grade books.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-10 py-5 bg-brand-600 text-white font-black rounded-2xl shadow-2xl shadow-brand-500/20 hover:scale-105 transition-all text-center">
                            {{ __('Start Free Trial') }}
                        </a>
                        <a href="#features"
                            class="w-full sm:w-auto px-10 py-5 bg-card text-txmain font-bold rounded-2xl border border-gray-200 hover:bg-page transition-all text-center">
                            {{ __('Explore Features') }}
                        </a>
                    </div>
                </div>

                <div class="lg:w-1/2 reveal">
                    <div class="relative group">
                        <div
                            class="absolute -inset-10 bg-brand-600 blur-[80px] opacity-70 group-hover:opacity-100 transition-opacity">
                        </div>
                        <img src="{{ asset('images/landing_hero_v2.png') }}" alt="{{ __('InvoiceMaker V2 Dashboard') }}"
                            class="w-full h-auto drop-shadow-2xl animate-float relative z-10 rounded-3xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-24 bg-card">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20 reveal">
                <h2 class="text-4xl font-black mb-4 text-heading">{{ __('How It Works') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    {{ __('Three simple steps to professional financial management.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="reveal p-8 text-center" style="transition-delay: 100ms">
                    <div
                        class="w-16 h-16 bg-brand-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        1</div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Create Your Profile') }}</h3>
                    <p class="text-txmain">
                        {{ __('Setup your business identity, upload your logo, and configure your global settings in seconds.') }}
                    </p>
                </div>
                <!-- Step 2 -->
                <div class="reveal p-8 text-center" style="transition-delay: 200ms">
                    <div
                        class="w-16 h-16 bg-brand-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        2</div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Invite Your Team') }}</h3>
                    <p class="text-txmain">
                        {{ __('Collaborate with your partners or accountants. Manage roles and track activities in real-time.') }}
                    </p>
                </div>
                <!-- Step 3 -->
                <div class="reveal p-8 text-center" style="transition-delay: 300ms">
                    <div
                        class="w-16 h-16 bg-brand-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold shadow-lg">
                        3</div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Generate & Grow') }}</h3>
                    <p class="text-txmain">
                        {{ __('Send beautiful invoices, track every cent in the cash book, and export insights to scale your business.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Ledger (Cash Book) Highlight -->
    <section class="py-32 bg-darkbox overflow-hidden relative">
        <div class="absolute top-0 inset-x-0 h-px bg-brand-600">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                <div class="lg:w-1/2 reveal">
                    <div class="bg-brand-600 p-[1px] rounded-[2.5rem] shadow-2xl">
                        <div class="bg-darkbox rounded-[2.5rem] overflow-hidden border border-gray-800">
                            <div
                                class="bg-gray-900/50 px-8 py-5 flex items-center justify-between border-b border-white/5 backdrop-blur-xl">
                                <div class="flex space-x-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-500/50"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-500/50"></div>
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-500/50"></div>
                                </div>
                                <span
                                    class="text-brand-400/50 text-[10px] font-mono tracking-tighter">realtime-ledger.sys</span>
                            </div>
                            <div class="p-10 space-y-6">
                                <div class="flex justify-between items-center group">
                                    <span
                                        class="text-xs font-mono text-white group-hover:text-white transition-colors tracking-tighter uppercase">{{ __('[RECORD]') }}
                                        {{ __('RE-2024-001') }}</span>
                                    <span class="text-sm font-black text-green-400 tracking-tight">+€1,250.00</span>
                                </div>
                                <div class="h-px bg-card/5"></div>
                                <div class="flex justify-between items-center group">
                                    <span
                                        class="text-xs font-mono text-white group-hover:text-red-400 transition-colors tracking-tighter uppercase">{{ __('[DEBIT]') }}
                                        {{ __('OFFICE EQUIP.') }}</span>
                                    <span class="text-sm font-black text-red-400 tracking-tight">-€79.00</span>
                                </div>
                                <div class="h-px bg-card/5"></div>
                                <div
                                    class="flex justify-between items-center bg-brand-500/5 p-4 rounded-xl border border-brand-500/10">
                                    <span
                                        class="text-xs font-mono text-white uppercase font-black tracking-widest">{{ __('Net Profit') }}</span>
                                    <span class="text-xl font-black text-white tracking-tight">€1,171.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 reveal">
                    <h2 class="text-5xl font-black text-white mb-8 leading-tight">
                        {{ __('Accountant-Grade') }}<br /><span
                            class="text-brand-500">{{ __('Cash Book Ledger') }}</span>
                    </h2>
                    <p class="text-white text-medium mb-10 leading-relaxed font-bold">
                        {{ __('No more messy spreadsheets. Our professional Cash Book Ledger system automatically tracks every transaction with double-entry precision. Built for speed, accuracy, and accountants.') }}
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-10 h-10 bg-brand-600/20 text-brand-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-black text-sm mb-1">{{ __('Unified Ledger') }}</h4>
                                <p class="text-amber-100 text-xs font-medium">{{ __('Income & Expense in one view.') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-10 h-10 bg-brand-600/20 text-brand-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-black text-sm mb-1">{{ __('Smart Profitability') }}</h4>
                                <p class="text-amber-100 text-xs font-medium">{{ __('Real-time job margin analysis.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Reach Section -->
    <section class="py-24 bg-card overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20 reveal">
                <h2 class="text-4xl font-black mb-4 text-heading">{{ __('Global Scale, Local Reach') }}</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    {{ __('Professionalism translated into the native tongues of your clients.') }}
                </p>
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
                        <div class="font-bold text-txmain">{{ __($f[1]) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-32 bg-page relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-24 reveal">
                <h2 class="text-5xl font-black mb-6 tracking-tight text-heading">{{ __('Simple, Transparent Pricing') }}
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg font-medium">
                    {{ __('Start for free and scale as you grow. No hidden fees, just pure professional power.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center">
                <!-- Free Plan -->
                <div
                    class="reveal glass-card p-12 rounded-[2.5rem] border-gray-100 flex flex-col items-center hover:shadow-2xl transition-all">
                    <h3 class="text-xl font-bold mb-2 text-gray-400 uppercase tracking-widest text-xs">
                        {{ __('Essential') }}
                    </h3>
                    <div class="flex items-baseline mb-8">
                        <span class="text-5xl font-black text-txmain">$0</span>
                        <span class="text-gray-400 ml-2 font-bold">/{{ __('mo') }}</span>
                    </div>
                    <ul class="space-y-4 mb-12 text-gray-500 text-sm w-full font-medium">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Up to 10 Invoices/mo') }}</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('All 10 Languages') }}</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Manual Cash Book') }}</li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="w-full py-4 bg-page text-txmain font-bold rounded-2xl hover:bg-gray-200 transition-all text-center">{{ __('Start Free') }}</a>
                </div>
                <!-- Pro Plan -->
                <div
                    class="reveal bg-card p-12 rounded-[3rem] border-2 border-brand-600 shadow-[0_40px_100px_-20px_rgba(37,99,235,0.2)] scale-110 z-10 relative flex flex-col items-center group">
                    <div
                        class="absolute -top-5 left-1/2 -translate-x-1/2 bg-brand-600 text-white text-[10px] font-black px-6 py-2 rounded-full uppercase tracking-widest shadow-xl">
                        {{ __('Most Popular') }}
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-brand-600 uppercase tracking-widest text-xs">
                        {{ __('Professional') }}
                    </h3>
                    <div class="flex items-baseline mb-8">
                        <span class="text-6xl font-black text-txmain">$19</span>
                        <span class="text-gray-400 ml-2 font-bold">/{{ __('mo') }}</span>
                    </div>
                    <ul class="space-y-4 mb-12 text-txmain text-sm w-full font-bold">
                        <li class="flex items-center"><svg class="w-5 h-5 text-brand-600 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Unlimited Invoices') }}</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-brand-600 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Custom SMTP Support') }}</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-brand-600 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Automated Records') }}</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-brand-600 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Priority Support') }}</li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="w-full py-5 bg-brand-600 text-white font-black rounded-2xl hover:scale-105 transition-all shadow-2xl shadow-brand-500/40 text-center">{{ __('Get Started Now') }}</a>
                </div>
                <!-- Enterprise Plan -->
                <div
                    class="reveal glass-card p-12 rounded-[2.5rem] border-gray-100 flex flex-col items-center hover:shadow-2xl transition-all">
                    <h3 class="text-xl font-bold mb-2 text-gray-400 uppercase tracking-widest text-xs">
                        {{ __('Enterprise') }}
                    </h3>
                    <div class="flex items-baseline mb-8">
                        <span class="text-5xl font-black text-txmain">$49</span>
                        <span class="text-gray-400 ml-2 font-bold">/{{ __('mo') }}</span>
                    </div>
                    <ul class="space-y-4 mb-12 text-gray-500 text-sm w-full font-medium">
                        <li class="flex items-center"><svg class="w-5 h-5 text-brand-500 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Advanced Analytics') }}</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-brand-500 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Dedicated Manager') }}</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-brand-500 mr-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> {{ __('Custom Integration') }}</li>
                    </ul>
                    <a href="{{ route('register') }}"
                        class="w-full py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition-all text-center">{{ __('Contact Sales') }}</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-32 bg-darkbox relative overflow-hidden">
        <div class="absolute inset-0 bg-brand-600 opacity-20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 reveal">
            <h2 class="text-5xl lg:text-7xl text-white font-black mb-10 tracking-tighter leading-none">
                {{ __('Ready to simplify your') }}<br /><span
                    class="text-brand-500">{{ __('financial empire?') }}</span>
            </h2>
            <a href="{{ route('register') }}"
                class="inline-block px-12 py-6 bg-white text-darkbox font-black text-xl rounded-3xl hover:scale-110 transition-all shadow-[0_20px_50px_rgba(255,255,255,0.15)] transform active:scale-95">
                {{ __('Create Your Account Free') }}
            </a>
            <p class="mt-8 text-amber-100 font-bold uppercase tracking-widest text-[10px]">
                {{ __('No credit card required') }}
            </p>
        </div>
    </section>
</x-landing-layout>