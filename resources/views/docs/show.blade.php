@component('layouts.public')
@section('title', $title)
@section('metaDescription', $description)

@section('seo_tags')
    <link rel="canonical" href="{{ route('docs.show', ['lang' => $currentLang, 'slug' => $slug]) }}" />
    @foreach($supportedLanguages as $code => $name)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ route('docs.show', ['lang' => $code, 'slug' => $slug]) }}" />
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ route('docs.show', ['lang' => 'en', 'slug' => $slug]) }}" />
@endsection

<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Sidebar -->
            <div class="w-full lg:w-1/4">
                <div class="sticky top-24">
                    <div class="mb-6">
                        <a href="{{ route('docs.index', ['lang' => $currentLang]) }}"
                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg class="mr-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Help Center
                        </a>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Articles in this Section
                            </h3>
                        </div>
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach($sidebarArticles as $index => $item)
                                <li>
                                    <a href="{{ route('docs.show', ['lang' => $currentLang, 'slug' => $item['slug']]) }}"
                                        class="flex items-center p-4 text-sm {{ $item['isActive'] ? 'font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-900/10' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                                        <span
                                            class="mr-3 flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full text-xs font-semibold {{ $item['isActive'] ? 'bg-brand-200 text-brand-700 dark:bg-brand-800 dark:text-brand-200' : 'bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                            {{ $index + 1 }}
                                        </span>
                                        {{ $item['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full lg:w-3/4">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                    <!-- Language Warning -->
                    @if($currentLang === 'en' && request()->route('lang') !== 'en')
                        <div
                            class="bg-yellow-50 dark:bg-yellow-900/30 border-b border-yellow-200 dark:border-yellow-800 p-4">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                <svg class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                This article is not yet available in your selected language. Showing English
                                translation.
                            </p>
                        </div>
                    @endif

                    <div
                        class="p-8 sm:p-12 prose prose-brand max-w-none [&_*]:!text-gray-900 dark:[&_*]:!text-gray-100 prose-a:!text-brand-600 dark:prose-a:!text-brand-400">
                        {!! $htmlContent !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endcomponent