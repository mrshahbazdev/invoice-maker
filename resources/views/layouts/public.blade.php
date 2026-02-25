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
    <!-- Navbar -->
    <nav class="bg-card/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
                        @if($logo = \App\Models\Setting::get('site.logo'))
                            <img class="h-10 w-auto" src="{{ Storage::url($logo) }}" alt="Logo">
                        @else
                            <span
                                class="text-2xl font-extrabold text-brand-600 tracking-tight">{{ \App\Models\Setting::get('site.name', config('app.name')) }}</span>
                        @endif
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('public.blog.index') }}"
                        class="text-txmain hover:text-txmain font-semibold text-sm transition-colors hidden sm:block">Blog</a>
                    <a href="{{ route('login') }}"
                        class="text-txmain hover:text-txmain font-semibold text-sm transition-colors">Sign In</a>
                    <a href="{{ route('register') }}"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-full text-sm font-bold transition-all shadow-sm">Get
                        Started</a>
                </div>
            </div>
        </div>
    </nav>

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