<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
 @yield('title', \App\Models\Setting::get('seo.meta_title', \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker'))))
 -
 @yield('subtitle', 'Access')</title>

 @if($favicon = \App\Models\Setting::get('site.favicon'))
 <link rel="icon" href="{{ Storage::url($favicon) }}">
 @else
 <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
 <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
 <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
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

 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
 <style>
 /* Premium auth shell: dark navy + orange, same language as the app redesign.
    Business theme variables still win when a business theme exists (var fallbacks). */
 .auth-shell, .auth-shell * { box-sizing: border-box; }
 .auth-shell {
   margin: 0;
   min-height: 100vh;
   display: grid;
   place-items: center;
   padding: 40px 16px;
   background-color: var(--color-page-bg, #0b1220);
   background-image: radial-gradient(640px 300px at 50% -80px, rgba(255, 140, 0, .18), transparent 70%);
   font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
 }
 .auth-wrap { width: 100%; max-width: 448px; }
 .auth-brand { text-align: center; margin-bottom: 24px; }
 .auth-brand-badge {
   width: 52px; height: 52px; margin: 0 auto 12px;
   display: flex; align-items: center; justify-content: center;
   background: #ff8c00; border-radius: 14px;
   box-shadow: 0 8px 24px rgba(255, 140, 0, .45);
 }
 .auth-brand-name { font-size: 20px; font-weight: 800; letter-spacing: -.01em; color: #ffffff; }
 .auth-card {
   position: relative; overflow: hidden;
   background: var(--color-card-bg, #ffffff);
   color: var(--color-text-main, #1f2937);
   border-radius: 16px; padding: 32px;
   box-shadow: 0 24px 60px rgba(0, 0, 0, .45), 0 2px 8px rgba(0, 0, 0, .25);
 }
 .auth-card::before {
   content: ""; position: absolute; top: 0; left: 0; right: 0; height: 4px;
   background: linear-gradient(90deg, #ff8c00, #ffb454);
 }
 .auth-head { text-align: center; margin-bottom: 28px; }
 .auth-title { font-size: 26px; font-weight: 800; letter-spacing: -.01em; margin: 0; color: var(--color-text-main, #0f172a); }
 .auth-sub { margin: 8px 0 0; font-size: 14px; color: var(--color-text-main, #1f2937); opacity: .68; }
 .auth-field { margin-bottom: 16px; }
 .auth-field-lg { margin-bottom: 24px; }
 .auth-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--color-text-main, #0f172a); }
 .auth-input {
   width: 100%; padding: 11px 14px; font-size: 15px; font-family: inherit;
   color: #0f172a; background: #ffffff; border: 1px solid #d1d5db; border-radius: 10px;
   transition: border-color .15s, box-shadow .15s;
 }
 .auth-input::placeholder { color: #94a3b8; }
 .auth-input:focus { border-color: #ff8c00; box-shadow: 0 0 0 3px rgba(255, 140, 0, .25); outline: none; }
 .auth-input[readonly] { background: #f8fafc; color: #64748b; }
 .auth-code { text-align: center; letter-spacing: .3em; font-size: 18px; font-weight: 600; }
 .auth-error { margin: 6px 0 0; font-size: 13px; color: #dc2626; }
 .auth-btn {
   width: 100%; display: flex; justify-content: center; align-items: center; gap: 8px;
   background: #ff8c00; color: #ffffff; font-family: inherit; font-size: 15px; font-weight: 700;
   padding: 12px 16px; border: none; border-radius: 10px; cursor: pointer;
   transition: background .2s;
 }
 .auth-btn:hover { background: #e07b00; }
 .auth-btn:focus-visible { outline: none; box-shadow: 0 0 0 3px rgba(255, 140, 0, .35); }
 .auth-btn:disabled { opacity: .5; cursor: default; }
 .auth-link { color: #ff8c00; font-weight: 600; text-decoration: none; }
 .auth-link:hover { color: #e07b00; }
 .auth-inline { font-size: 14px; color: var(--color-text-main, #1f2937); }
 .auth-foot { margin-top: 24px; text-align: center; }
 .auth-row-between { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
 .auth-row-end { display: flex; justify-content: flex-end; margin-bottom: 24px; }
 .auth-check-label { display: flex; align-items: center; gap: 8px; cursor: pointer; }
 .auth-check { width: 16px; height: 16px; accent-color: #ff8c00; margin: 0; }
 .auth-toggle { font-family: inherit; font-size: 13px; color: var(--color-text-main, #1f2937); opacity: .85; text-decoration: underline; background: none; border: none; padding: 0; cursor: pointer; }
 .auth-flash-ok { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; }
 .auth-flash-err { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; }
 .auth-flash-err ul { margin: 0; padding-left: 18px; }
 .auth-status { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; font-weight: 500; }
 @media (max-width: 480px) {
   .auth-shell { padding: 24px 12px; }
   .auth-card { padding: 24px 20px; }
 }
 </style>
</head>

<body class="auth-shell">
 <div class="auth-wrap">
 <div class="auth-brand">
 <div class="auth-brand-badge">
 <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></svg>
 </div>
 <div class="auth-brand-name">{{ \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker')) }}</div>
 </div>
 <div class="auth-card">
 @if(session('message'))
 <div class="auth-flash-ok">
 {{ session('message') }}
 </div>
 @endif

 @if($errors->any())
 <div class="auth-flash-err">
 <ul>
 @foreach($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
 @endif

 {{ $slot }}
 </div>
 </div>

 @livewireScripts
</body>

</html>