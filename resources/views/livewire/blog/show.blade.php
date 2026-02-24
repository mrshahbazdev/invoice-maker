<div class="bg-gray-50 min-h-screen">
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
        <!-- Post Header -->
        <header class="text-center mb-12">
            @if($post->category)
                <a href="{{ route('public.blog.index', ['category' => $post->category->slug]) }}"
                    class="inline-block mb-4 text-xs font-bold tracking-widest text-indigo-600 uppercase">
                    {{ $post->category->name }}
                </a>
            @endif

            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-6 leading-tight">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-center text-sm text-gray-500 space-x-4">
                <time datetime="{{ $post->published_at->format('Y-m-d') }}" class="flex items-center">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    {{ $post->published_at->format('M d, Y') }}
                </time>
                <span class="flex items-center">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                </span>
            </div>
        </header>

        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="mb-12 rounded-3xl overflow-hidden shadow-2xl relative aspect-video">
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Post Content -->
        <div
            class="prose prose-lg prose-indigo mx-auto text-gray-600 bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">
            {!! $post->content !!}
        </div>

        <!-- Footer / CTA -->
        <div
            class="mt-16 bg-indigo-900 rounded-3xl p-8 md:p-12 text-center text-white shadow-xl relative overflow-hidden">
            <div
                class="absolute -top-24 -left-24 w-48 h-48 bg-indigo-600 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob">
            </div>
            <div
                class="absolute -bottom-24 -right-24 w-48 h-48 bg-purple-600 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-2000">
            </div>

            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold mb-4">Start your journey today</h2>
                <p class="text-indigo-200 mb-8 max-w-2xl mx-auto">
                    Join thousands of entrepreneurs using our platform to generate professional invoices and get paid
                    faster. No credit card required.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-white text-indigo-900 font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                        Create Free Account
                    </a>
                    <a href="{{ route('public.blog.index') }}"
                        class="px-8 py-4 bg-indigo-800 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors border border-indigo-700">
                        Read More Articles
                    </a>
                </div>
            </div>
        </div>
    </article>
</div>