<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'InvoiceMaker')) - Professional Invoicing for Everyone</title>
    <meta name="description"
        content="@yield('meta_description', 'The ultimate invoicing solution for freelancers and small businesses worldwide. Create, send, and track invoices in minutes.')">

    <!-- Open Graph / SEO -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', config('app.name', 'InvoiceMaker'))">
    <meta property="og:description"
        content="@yield('meta_description', 'The ultimate invoicing solution for freelancers and small businesses worldwide.')">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .mesh-gradient {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 0% 0%, hsla(217, 100%, 97%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225, 100%, 96%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(210, 100%, 95%, 1) 0, transparent 50%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased selection:bg-blue-100 selection:text-blue-700">

    <!-- Header -->
    <header x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white/80 backdrop-blur-lg shadow-sm py-3' : 'bg-transparent py-5'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-8">
        <nav class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <a href="/" class="flex items-center group">
                    <div
                        class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="ml-3 text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                        {{ config('app.name', 'InvoiceMaker') }}
                    </span>
                </a>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#features"
                    class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">{{ __('Features') }}</a>
                <a href="#how-it-works"
                    class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">{{ __('How it Works') }}</a>

                <!-- Language Selector -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.53 3 18.051">
                            </path>
                        </svg>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden transform transition-all">
                        @php
                            $locales = [
                                'en' => 'English',
                                'de' => 'Deutsch',
                                'es' => 'Español',
                                'fr' => 'Français',
                                'it' => 'Italiano',
                                'pt' => 'Português',
                                'ar' => 'العربية',
                                'zh' => '中文',
                                'ja' => '日本語',
                                'ru' => 'Русский',
                            ];
                        @endphp
                        @foreach($locales as $code => $name)
                            <a href="{{ route('language.switch', $code) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 {{ app()->getLocale() == $code ? 'font-bold bg-gray-50' : '' }}">
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center space-x-4 ml-4 pl-4 border-l border-gray-200">
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-gray-700 hover:text-blue-600 transition-colors">{{ __('Sign In') }}</a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 shadow-lg shadow-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                        {{ __('Get Started') }}
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center space-x-4">
                <!-- Language Selector Mobile -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 text-gray-600 hover:text-blue-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.53 3 18.051">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                        @foreach($locales as $code => $name)
                            <a href="{{ route('language.switch', $code) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <button @click="mobileMenuOpen = true" class="p-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Nav Overlay -->
        <div x-show="mobileMenuOpen" x-cloak
            class="md:hidden fixed inset-0 z-50 flex flex-col bg-white overflow-y-auto">
            <div class="px-4 py-5 flex items-center justify-between border-b border-gray-100">
                <a href="/" class="flex items-center">
                    <span
                        class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                        {{ config('app.name', 'InvoiceMaker') }}
                    </span>
                </a>
                <button @click="mobileMenuOpen = false" class="p-2 text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="px-4 py-8 space-y-6">
                <a href="#features" @click="mobileMenuOpen = false"
                    class="block text-lg font-medium text-gray-900">{{ __('Features') }}</a>
                <a href="#how-it-works" @click="mobileMenuOpen = false"
                    class="block text-lg font-medium text-gray-900">{{ __('How it Works') }}</a>
                <div class="pt-6 border-t border-gray-100 space-y-4">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center px-6 py-3 text-lg font-semibold text-gray-900 border border-gray-200 rounded-2xl">{{ __('Sign In') }}</a>
                    <a href="{{ route('register') }}"
                        class="block w-full text-center px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-2xl">{{ __('Get Started') }}</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12 border-b border-gray-800 pb-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="/" class="flex items-center mb-6">
                        <span class="text-2xl font-bold text-white">{{ config('app.name', 'InvoiceMaker') }}</span>
                    </a>
                    <p class="text-sm leading-relaxed">
                        {{ __('Manage your business smarter, not harder. The most automated invoicing platform built for modern entrepreneurs.') }}
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">{{ __('Product') }}</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#features" class="hover:text-blue-400 transition-colors">{{ __('Features') }}</a>
                        </li>
                        <li><a href="#pricing" class="hover:text-blue-400 transition-colors">{{ __('Pricing') }}</a>
                        </li>
                        <li><a href="/client/login"
                                class="hover:text-blue-400 transition-colors">{{ __('Client Portal') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">{{ __('Support') }}</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">{{ __('Documentation') }}</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">{{ __('Privacy Policy') }}</a>
                        </li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">{{ __('Terms of Service') }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-xs">{{ __('Newsletter') }}</h4>
                    <p class="text-xs mb-4">{{ __('Subscribe to get the latest business tips.') }}</p>
                    <div class="flex">
                        <input type="email" placeholder="{{ __('Email address') }}"
                            class="bg-gray-800 border-none rounded-l-lg px-4 py-2 w-full text-white text-sm focus:ring-1 focus:ring-blue-500">
                        <button
                            class="bg-blue-600 text-white rounded-r-lg px-4 py-2 hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center text-xs">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'InvoiceMaker') }}. {{ __('All rights reserved.') }}</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <p>{{ __('Built with passion for global entrepreneurs.') }}</p>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>