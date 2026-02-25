<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>{{ $title ?? 'Client Portal' }} - {{ config('app.name', 'InvoiceMaker') }}</title>
 @vite(['resources/css/app.css', 'resources/js/app.js'])
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
 rel="stylesheet">
 <style>
 body {
 font-family: 'Inter', sans-serif;
 background-color: #f9fafb;
 color: #111827;
 }
 </style>
 @livewireStyles
</head>

<body class="min-h-screen flex flex-col antialiased">

 <!-- Navbar -->
 <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
 <div class="flex justify-between items-center h-16">
 <!-- Left side -->
 <div class="flex items-center">
 <div class="flex-shrink-0 flex items-center">
 <div
 class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white font-bold text-lg mr-3 shadow-md shadow-brand-600/20">
 {{ substr(auth()->user()->name, 0, 1) }}
 </div>
 <div>
 <h1 class="text-sm sm:text-lg font-bold text-gray-900 leading-tight">Client Portal</h1>
 <p class="hidden sm:block text-[10px] text-gray-500 font-medium lowercase">Welcome,
 {{ auth()->user()->name }}</p>
 </div>
 </div>
 </div>

 <!-- Right side -->
 <div class="flex items-center space-x-3 sm:space-x-6">
 <a href="{{ route('client.dashboard') }}"
 class="text-xs sm:text-sm font-medium {{ request()->routeIs('client.dashboard') ? 'text-brand-600' : 'text-gray-500 hover:text-gray-900' }} transition-colors duration-150 flex items-center">
 <svg class="w-4 h-4 mr-1 sm:mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round"
 d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
 </svg>
 <span class="hidden sm:inline">Dashboard</span>
 </a>
 <a href="{{ route('client.settings') }}"
 class="text-xs sm:text-sm font-medium {{ request()->routeIs('client.settings') ? 'text-brand-600' : 'text-gray-500 hover:text-gray-900' }} transition-colors duration-150 flex items-center">
 <svg class="w-4 h-4 mr-1 sm:mr-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round"
 d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
 <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
 </svg>
 <span class="hidden sm:inline">Settings</span>
 </a>
 <form action="{{ route('logout') }}" method="POST">
 @csrf
 <button type="submit"
 class="text-xs sm:text-sm font-medium text-red-500 hover:text-red-700 transition-colors duration-150">
 Sign out
 </button>
 </form>
 </div>
 </div>
 </div>
 </nav>

 <!-- Main Content -->
 <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
 {{ $slot }}
 </main>

 @livewireScripts
</body>

</html>