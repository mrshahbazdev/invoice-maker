<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title', $title ?? \App\Models\Setting::get('seo.meta_title', \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker'))))
    </title>
    @if(isset($metaDescription))
        <meta name="description" content="{{ $metaDescription }}">
    @else
        <meta name="description"
            content="{{ \App\Models\Setting::get('seo.meta_description', 'Invoice and Billing software') }}">
    @endif

    @if($favicon = \App\Models\Setting::get('site.favicon'))
        <link rel="icon" href="{{ Storage::url($favicon) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @if(auth()->check() && auth()->user()->business)
        <style>
            @if(auth()->user()->business->theme)
                {!! \App\Services\ThemeGenerator::generateCssVariables(auth()->user()->business->theme->primary_color) !!}
            @endif :root {
                --color-page-bg:
                    {{ optional(auth()->user()->business->pageBgColor)->primary_color ?? '#f3f4f6' }}
                ;
                --color-card-bg:
                    {{ optional(auth()->user()->business->cardBgColor)->primary_color ?? '#ffffff' }}
                ;
                --color-text-main:
                    {{ optional(auth()->user()->business->textColor)->primary_color ?? '#1f2937' }}
                ;
            }
        </style>
    @endif
</head>

<body class="bg-page text-txmain antialiased font-sans flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">

    @if(session()->has('impersonated_by'))
        <div
            class="fixed top-0 inset-x-0 z-[100] bg-red-600 text-white px-4 py-2.5 flex justify-center sm:justify-between items-center shadow-md flex-wrap gap-2 text-sm sm:text-base">
            <span class="font-medium text-center">
                🕵️ You are currently masquerading as <strong
                    class="font-bold border-b border-red-300">{{ auth()->user()->name }}</strong>.
            </span>
            <form action="{{ route('impersonate.leave') }}" method="POST" class="m-0">
                @csrf
                <button type="submit"
                    class="bg-card text-red-600 px-3 py-1.5 rounded-md text-xs sm:text-sm font-bold shadow-sm hover:bg-page transition-colors">
                    Leave God Mode
                </button>
            </form>
        </div>
        <style>
            body {
                padding-top: 50px;
            }
        </style>
    @endif
    <div class="flex min-h-screen">
        @if(auth()->check())
            @include('components.sidebar')
        @endif

        <div class="flex-1 flex flex-col @if(auth()->check()) lg:pl-64 @endif">
            @if(auth()->check())
                <header
                    class="bg-card border-b border-gray-200/50 px-4 sm:px-6 py-4 sticky top-0 z-40 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center min-w-0">
                            <!-- Mobile menu button -->
                            @if(auth()->check())
                                <button @click.stop="mobileMenuOpen = true"
                                    class="mr-3 text-gray-500 hover:text-brand-600 focus:outline-none lg:hidden flex-shrink-0 p-1 rounded-lg hover:bg-page transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                            @endif
                            <h1 class="text-lg sm:text-2xl font-bold text-txmain truncate pr-2">
                                {{ $title ?? __('Dashboard') }}
                            </h1>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-4 flex-shrink-0">
                            <!-- Language Switcher (Condensed on mobile) -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center text-xs sm:text-sm text-txmain hover:text-brand-600 focus:outline-none transition-colors border border-gray-200 px-2 py-1 rounded-md bg-card sm:bg-transparent">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.53 3 18.051">
                                        </path>
                                    </svg>
                                    <span class="font-bold">{{ strtoupper(app()->getLocale()) }}</span>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-card rounded-md shadow-lg py-1 z-50 border border-gray-100 ring-1 ring-black ring-opacity-5"
                                    style="display: none;">
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
                                            class="block px-4 py-2 text-sm text-txmain hover:bg-brand-50 hover:text-brand-700 @if(app()->getLocale() == $code) font-bold bg-page @endif">
                                            {{ $name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <a href="{{ route('profile.show') }}"
                                class="flex items-center text-xs sm:text-sm text-txmain hover:text-brand-600 focus:outline-none transition-colors px-2 py-1.5 rounded-md hover:bg-page font-medium">
                                <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="hidden sm:inline">{{ __('Profile') }}</span>
                            </a>

                            @if(auth()->user() && auth()->user()->is_super_admin)
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center text-xs sm:text-sm text-brand-600 hover:text-brand-800 focus:outline-none transition-colors px-2 py-1.5 rounded-md hover:bg-brand-50 font-bold border border-brand-200 mr-2 sm:mr-0">
                                    <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Admin Mode</span>
                                </a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="p-1.5 sm:px-3 sm:py-1.5 text-xs sm:text-sm text-red-600 hover:text-white border border-red-200 sm:border-transparent hover:bg-red-600 rounded-lg font-medium transition-all duration-200">
                                    <span class="hidden sm:inline">{{ __('Logout') }}</span>
                                    <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>
            @endif

            <main class="flex-1 p-6">
                @if(session('message'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>