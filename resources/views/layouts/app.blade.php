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
    class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen">
    <div class="flex min-h-screen">
        @if(auth()->check())
            @include('components.sidebar')
        @endif

        <div class="flex-1 flex flex-col @if(auth()->check()) lg:pl-64 @endif">
            @if(auth()->check())
                <header class="bg-white/70 backdrop-blur-md border-b border-gray-200/50 px-6 py-4 sticky top-0 z-40">
                    <div class="flex items-center justify-between">
                        <h1
                            class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                            {{ $title ?? 'Dashboard' }}
                        </h1>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-700">Logout</button>
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