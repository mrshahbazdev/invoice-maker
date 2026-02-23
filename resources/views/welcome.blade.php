<x-landing-layout>
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight mb-8 leading-tight">
                    {{ __('Invoicing that feels like') }}
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                        {{ __('magic.') }}
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-2xl mx-auto">
                    {{ __('The ultimate multi-tenant SaaS platform for global businesses. Create professional invoices, manage clients, and track exports in 10 languages.') }}
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all">
                        {{ __('Start For Free') }}
                    </a>
                    <a href="#features"
                        class="w-full sm:w-auto px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all">
                        {{ __('See Features') }}
                    </a>
                </div>
            </div>

            <!-- Hero Image / Interface Mockup -->
            <div class="mt-20 relative px-4 lg:px-0">
                <div class="absolute -inset-4 bg-gradient-to-tr from-blue-600/20 to-indigo-600/20 blur-3xl opacity-50">
                </div>
                <div
                    class="relative bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 transform -rotate-1 hover:rotate-0 transition-transform duration-700">
                    <img src="{{ asset('images/landing_hero.png') }}" alt="SaaS Dashboard Preview"
                        class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-3xl font-bold mb-4">{{ __('Built for the Modern Entrepreneur') }}</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-100">
                    <div
                        class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Automated Invoicing') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Set it and forget it. Generate recurring invoices and send automated payment reminders to your clients.') }}
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-100">
                    <div
                        class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.53 3 18.051">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Global Ready') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Translate your entire experience into 10 world languages. Perfect for entrepreneurs with international clients.') }}
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-100">
                    <div
                        class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">{{ __('Cash Book System') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __('Manage your income and expenses in a unified professional ledger. Export high-quality data for your accountant.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="py-24 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <h2 class="text-4xl font-bold mb-6 leading-tight">
                        {{ __('Loved by entrepreneurs in 50+ countries.') }}
                    </h2>
                    <p class="text-lg text-gray-600 mb-8">
                        {{ __('Join thousands of business owners who have simplified their financial management.') }}
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="flex -space-x-2">
                            <img class="w-10 h-10 rounded-full border-2 border-white"
                                src="https://i.pravatar.cc/100?u=1" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-white"
                                src="https://i.pravatar.cc/100?u=2" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-white"
                                src="https://i.pravatar.cc/100?u=3" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-white"
                                src="https://i.pravatar.cc/100?u=4" alt="User">
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ __('4.9/5 Average Rating') }}</span>
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-1 rounded-3xl shadow-3xl">
                        <div class="bg-white p-10 rounded-3xl">
                            <p class="text-xl italic text-gray-700 mb-6">
                                "{{ __('This platform changed the way I handle my freelance business. The multi-language support is a game changer for my German clients.') }}"
                            </p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gray-200 rounded-full mr-4"></div>
                                <div>
                                    <h5 class="font-bold">Alex Johnson</h5>
                                    <span class="text-sm text-gray-500">Creative Director</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl text-white font-bold mb-8">{{ __('Ready to simplify your business?') }}</h2>
            <a href="{{ route('register') }}"
                class="inline-block px-10 py-5 bg-white text-blue-600 font-extrabold rounded-2xl hover:scale-105 transition-all shadow-xl">
                {{ __('Create Your Account Now') }}
            </a>
        </div>
    </section>
</x-landing-layout>