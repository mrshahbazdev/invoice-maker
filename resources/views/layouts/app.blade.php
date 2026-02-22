<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'InvoiceMaker') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen"
    x-data="{ mobileMenuOpen: false }">
    <div class="flex min-h-screen">
        @if(auth()->check())
            @include('components.sidebar')
        @endif

        <div class="flex-1 flex flex-col @if(auth()->check()) lg:pl-64 @endif">
            @if(auth()->check())
                <header class="bg-white/70 backdrop-blur-md border-b border-gray-200/50 px-6 py-4 sticky top-0 z-40">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            @if(auth()->check())
                                <button @click="mobileMenuOpen = true"
                                    class="mr-4 text-gray-500 hover:text-blue-600 focus:outline-none lg:hidden">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                            @endif
                            <h1
                                class="text-xl lg:text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 truncate">
                                {{ $title ?? 'Dashboard' }}
                            </h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Quick Language Switcher -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center text-sm text-gray-600 hover:text-blue-600 focus:outline-none transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.53 3 18.051">
                                        </path>
                                    </svg>
                                    {{ strtoupper(app()->getLocale()) }}
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100 ring-1 ring-black ring-opacity-5"
                                    style="display: none;">
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
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 @if(app()->getLocale() == $code) font-bold bg-gray-50 @endif">
                                            {{ $name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <span class="text-sm text-gray-600 font-medium">{{ auth()->user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-red-600 hover:text-red-700 font-medium hover:underline transition-all">
                                    {{ __('Logout') }}
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