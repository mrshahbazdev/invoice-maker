<div class="bg-white min-h-screen pb-24">
    <article>
        <!-- Post Header -->
        <header class="pt-24 pb-12 lg:pt-32 lg:pb-16 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto text-center">
            @if($post->category)
                <a href="{{ route('public.blog.index', ['category' => $post->category->slug]) }}"
                    class="inline-block mb-6 text-xs font-bold tracking-widest text-blue-600 uppercase border border-blue-200 bg-blue-50 px-3 py-1 rounded-full hover:bg-blue-100 transition-colors">
                    {{ $post->category->name }}
                </a>
            @endif

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight mb-8">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-center text-sm font-semibold text-gray-500 uppercase tracking-wide">
                <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                    {{ $post->published_at->format('M d, Y') }}
                </time>
                <span class="mx-3">&bull;</span>
                <span>
                    {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} MIN READ
                </span>
            </div>
        </header>

        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
                <div class="aspect-[21/9] w-full rounded-[2rem] overflow-hidden shadow-2xl relative">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-[2rem]"></div>
                </div>
            </div>
        @endif

        <!-- Post Content -->
        <div class="px-4 sm:px-6 lg:px-8">
            <div
                class="max-w-3xl mx-auto prose prose-lg prose-blue text-gray-700 prose-headings:font-bold prose-headings:text-gray-900 prose-a:text-blue-600 hover:prose-a:text-blue-800 prose-img:rounded-2xl prose-img:shadow-lg">
                {!! $post->content !!}
            </div>
        </div>
    </article>

    <!-- Post Footer CTA -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
        <div
            class="bg-gray-50 rounded-[2.5rem] p-10 md:p-16 text-center border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div
                    class="absolute -top-24 -left-24 w-64 h-64 bg-blue-100 rounded-full mix-blend-multiply opacity-50 filter blur-3xl">
                </div>
                <div
                    class="absolute -bottom-24 -right-24 w-64 h-64 bg-indigo-100 rounded-full mix-blend-multiply opacity-50 filter blur-3xl">
                </div>
            </div>

            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4 tracking-tight">Start your journey today</h2>
                <p class="text-gray-500 mb-10 max-w-2xl mx-auto text-lg leading-relaxed">
                    Join thousands of entrepreneurs using our platform to generate professional invoices and get paid
                    faster.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition-colors shadow-lg">
                        Create Free Account
                    </a>
                    <a href="{{ route('public.blog.index') }}"
                        class="px-8 py-4 bg-white text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors border border-gray-200 shadow-sm">
                        Read More Articles
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>