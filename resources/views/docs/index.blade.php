@component('layouts.public')
<x-slot:title>Documentation - {{ config('app.name', 'Invoice Maker') }}</x-slot:title>
<x-slot:metaDescription>Complete user guides, tutorials, and documentation for the
    {{ config('app.name', 'Invoice Maker') }} platform.</x-slot:metaDescription>

<div class="py-12 lg:py-20 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl lg:text-6xl tracking-tight">
                Help Center & Documentation
            </h1>
            <p class="mt-5 text-xl text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Everything you need to know to run your business smoothly. Master our invoicing, accounting, and AI
                features today.
            </p>

            <!-- Language Selector -->
            <div class="mt-8 flex justify-center">
                <div class="relative inline-block text-left w-64">
                    <select onchange="window.location.href=this.value"
                        class="mt-1 block w-full pl-4 pr-10 py-3 text-base border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm rounded-xl shadow-sm cursor-pointer transition-shadow hover:shadow-md">
                        @foreach($supportedLanguages as $code => $name)
                            <option value="{{ route('docs.index', ['lang' => $code]) }}" {{ $currentLang === $code ? 'selected' : '' }}>
                                Translate: {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4 sm:px-0">
            @foreach($articles as $article)
                <a href="{{ route('docs.show', ['lang' => $currentLang, 'slug' => $article['slug']]) }}"
                    class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-brand-50 to-transparent dark:from-brand-900/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>

                    <div class="relative flex-grow">
                        <div
                            class="flex items-center mb-3 text-brand-600 dark:text-brand-400 font-bold text-xs tracking-widest uppercase">
                            Step {{ $loop->iteration }}
                        </div>
                        <h3
                            class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors mb-4">
                            {{ $article['title'] }}
                        </h3>
                        <p class="text-base text-gray-500 dark:text-gray-400 line-clamp-3 leading-relaxed">
                            {{ $article['description'] }}
                        </p>
                    </div>

                    <div class="relative mt-8 flex items-center text-sm font-semibold text-brand-600 dark:text-brand-400">
                        Read guide
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>

        @if(count($articles) === 0)
            <div
                class="text-center py-24 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mt-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No documentation found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">We are currently translating these articles.</p>
            </div>
        @endif

    </div>
</div>
@endcomponent