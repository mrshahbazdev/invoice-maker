<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title', $title ?? \App\Models\Setting::get('seo.meta_title', \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker'))))
    </title>
    @if(isset($metaDescription))
        <meta name="description" content="{{ $metaDescription }}">
        <meta property="og:description" content="{{ $metaDescription }}">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:title"
        content="@yield('title', $title ?? \App\Models\Setting::get('seo.meta_title', \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker'))))">
    @if(\App\Models\Setting::get('seo.og_image'))
        <meta property="og:image" content="{{ url(Storage::url(\App\Models\Setting::get('seo.og_image'))) }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">

    @yield('seo_tags')

    @if($favicon = \App\Models\Setting::get('site.favicon'))
        <link rel="icon" href="{{ Storage::url($favicon) }}">
    @endif

    <!-- Custom Header Scripts & GA -->
    @if(\App\Models\Setting::get('seo.google_analytics_id'))
        <!-- Google tag (gtag.js) -->
        <script async
            src="https://www.googletagmanager.com/gtag/js?id={{ \App\Models\Setting::get('seo.google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());

            gtag('config', '{{ \App\Models\Setting::get('seo.google_analytics_id') }}');
        </script>
    @endif

    {!! \App\Models\Setting::get('seo.custom_header_scripts') !!}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-card text-txmain antialiased font-sans flex flex-col min-h-screen">
    <!-- Header -->
    <header x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-card shadow-sm py-3' : 'bg-card py-5'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-8 border-b border-gray-100">
        <nav class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <a href="/" class="flex items-center group">
                    @if($logo = \App\Models\Setting::get('site.logo'))
                        <img src="{{ Storage::url($logo) }}" alt="Logo"
                            class="h-10 w-auto group-hover:scale-105 transition-transform">
                    @else
                        <div
                            class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <span class="ml-3 text-2xl font-bold text-brand-600">
                            {{ \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker')) }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/#features"
                    class="text-sm font-medium text-txmain hover:text-brand-600 transition-colors">{{ __('Features') }}</a>
                <a href="/#how-it-works"
                    class="text-sm font-bold text-heading hover:text-brand-600 transition-colors">{{ __('How it Works') }}</a>
                <a href="{{ route('docs.index', ['lang' => app()->getLocale()]) }}"
                    class="text-sm font-bold text-heading hover:text-brand-600 transition-colors">{{ __('Help Center') }}</a>
                <a href="{{ route('public.blog.index') }}"
                    class="text-sm font-bold text-heading hover:text-brand-600 transition-colors">{{ __('Blog') }}</a>
                <a href="https://allocore.de/" target="_blank" rel="noopener" title="Visit Allocore Main Website"
                    class="text-sm font-bold text-heading hover:text-brand-600 transition-colors">{{ __('Allocore.de') }}</a>

                <!-- Language Selector -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center text-sm font-medium text-txmain hover:text-brand-600 transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.53 3 18.051">
                            </path>
                        </svg>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                        class="absolute right-0 mt-2 w-48 bg-card rounded-xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden transform transition-all">
                        @php
                            $locales = \App\Models\Setting::get('site.enabled_languages', [
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
                            ]);
                         @endphp
                        @foreach($locales as $code => $name)
                            <a href="{{ route('language.switch', $code) }}"
                                class="block px-4 py-2 text-sm text-txmain hover:bg-brand-50 hover:text-brand-700 {{ app()->getLocale() == $code ? 'font-bold bg-page' : '' }}">
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center space-x-4 ml-4 pl-4 border-l border-gray-200">
                    @auth
                        <a href="{{ auth()->user()->role === 'client' ? route('client.dashboard') : route('dashboard') }}"
                            class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-brand-600 rounded-full hover: shadow-lg shadow-brand-200 transition-all transform hover:-translate-y-0.5">
                            {{ __('Go to Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-txmain hover:text-brand-600 transition-colors">{{ __('Sign In') }}</a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-brand-600 rounded-full hover:bg-brand-700 shadow-lg shadow-brand-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all">
                            {{ __('Get Started') }}
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center space-x-4">
                <!-- Language Selector Mobile -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 text-txmain hover:text-brand-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.53 3 18.051">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                        class="absolute right-0 mt-2 w-48 bg-card rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                        @foreach($locales as $code => $name)
                            <a href="{{ route('language.switch', $code) }}"
                                class="block px-4 py-2 text-sm text-txmain hover:bg-brand-50">
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <button @click="mobileMenuOpen = true" class="p-2 text-txmain hover:text-brand-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Nav Overlay -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden fixed inset-0 z-50 flex flex-col bg-card overflow-y-auto">
            <div class="px-4 py-5 flex items-center justify-between border-b border-gray-100">
                <a href="/" class="flex items-center">
                    @if($logo = \App\Models\Setting::get('site.logo'))
                        <img src="{{ Storage::url($logo) }}" alt="Logo" class="h-8 w-auto">
                    @else
                        <span class="text-xl font-bold text-brand-600">
                            {{ \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker')) }}
                        </span>
                    @endif
                </a>
                <button @click="mobileMenuOpen = false" class="p-2 text-txmain">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="px-4 py-8 space-y-6">
                <a href="/#features" @click="mobileMenuOpen = false"
                    class="block text-lg font-medium text-txmain">{{ __('Features') }}</a>
                <a href="/#how-it-works" @click="mobileMenuOpen = false"
                    class="block text-lg font-medium text-txmain">{{ __('How it Works') }}</a>
                <a href="{{ route('docs.index', ['lang' => app()->getLocale()]) }}" @click="mobileMenuOpen = false"
                    class="block text-lg font-medium text-txmain">{{ __('Help Center') }}</a>
                <a href="{{ route('public.blog.index') }}" @click="mobileMenuOpen = false"
                    class="block text-lg font-medium text-txmain">{{ __('Blog') }}</a>
                <a href="https://allocore.de/" target="_blank" rel="noopener" title="Visit Allocore Main Website"
                    class="block text-lg font-medium text-txmain">{{ __('Allocore.de') }}</a>
                <div class="pt-6 border-t border-gray-100 space-y-4">
                    @auth
                        <a href="{{ auth()->user()->role === 'client' ? route('client.dashboard') : route('dashboard') }}"
                            class="block w-full text-center px-6 py-4 text-lg font-bold text-white bg-brand-600 rounded-2xl shadow-xl">
                            {{ __('Go to Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center px-6 py-3 text-lg font-semibold text-txmain border border-gray-200 rounded-2xl">{{ __('Sign In') }}</a>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-6 py-3 text-lg font-semibold text-white bg-brand-600 rounded-2xl">{{ __('Get Started') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-card border-t border-gray-100 mt-auto">
        <div
            class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="flex justify-center space-x-6 md:order-2 mb-4 md:mb-0">
                <p class="text-base text-gray-500 font-medium">
                    &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site.name', config('app.name')) }}. All rights
                    reserved.
                </p>
            </div>
            <div class="mt-8 md:mt-0 md:order-1 flex justify-center space-x-6">
                <a href="https://allocore.de/" target="_blank" rel="noopener" title="Visit Allocore Main Website" class="text-gray-400 hover:text-gray-500 font-medium text-sm">Allocore.de</a>
                <a href="{{ url('/') }}" class="text-gray-400 hover:text-gray-500 font-medium text-sm">Home</a>
                <a href="{{ route('public.blog.index') }}"
                    class="text-gray-400 hover:text-gray-500 font-medium text-sm">Blog</a>
                <a href="{{ route('docs.index', ['lang' => app()->getLocale()]) }}"
                    class="text-gray-400 hover:text-gray-500 font-medium text-sm">Help Center</a>
                <a href="{{ route('login') }}" class="text-gray-400 hover:text-gray-500 font-medium text-sm">Login</a>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>