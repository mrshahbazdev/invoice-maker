<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>
 @yield('title', \App\Models\Setting::get('seo.meta_title', \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker'))))
 -
 @yield('subtitle', 'Access')</title>

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

 @if(isset($business))
 <style>
 @if($business->theme)
 {!! \App\Services\ThemeGenerator::generateCssVariables($business->theme->primary_color) !!}
 @endif
 :root {
    --color-page-bg: {{ optional($business->pageBgColor)->primary_color ?? '#f3f4f6' }};
    --color-card-bg: {{ optional($business->cardBgColor)->primary_color ?? '#ffffff' }};
    --color-text-main: {{ optional($business->textColor)->primary_color ?? '#1f2937' }};
 }
 </style>
 @elseif(auth()->check() && auth()->user()->business)
 <style>
 @if(auth()->user()->business->theme)
 {!! \App\Services\ThemeGenerator::generateCssVariables(auth()->user()->business->theme->primary_color) !!}
 @endif
 :root {
    --color-page-bg: {{ optional(auth()->user()->business->pageBgColor)->primary_color ?? '#f3f4f6' }};
    --color-card-bg: {{ optional(auth()->user()->business->cardBgColor)->primary_color ?? '#ffffff' }};
    --color-text-main: {{ optional(auth()->user()->business->textColor)->primary_color ?? '#1f2937' }};
 }
 </style>
 @endif
</head>

<body class="bg-page flex items-center justify-center min-h-screen">
 <div class="bg-card p-8 rounded-lg shadow-md w-full max-w-md">
 @if(session('message'))
 <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
 {{ session('message') }}
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
 </div>

 @livewireScripts
</body>

</html>