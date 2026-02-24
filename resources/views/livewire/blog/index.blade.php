<div class="bg-white min-h-screen">
    <!-- Header Section -->
    <div class="bg-indigo-900 text-white py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
                @if($category)
                    Category: <span
                        class="text-indigo-300">{{ App\Models\Category::where('slug', $category)->value('name') }}</span>
                @else
                    Invoice Maker Blog
                @endif
            </h1>
            <p class="text-xl text-indigo-200 max-w-3xl mx-auto">
                Insights, guides, and tips to help you manage your business finances better.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Main Content -->
            <div class="lg:w-3/4">
                @if($posts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($posts as $post)
                            <article
                                class="flex flex-col rounded-2xl shadow-lg overflow-hidden bg-white border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                                <a href="{{ route('public.blog.show', $post->slug) }}"
                                    class="flex-shrink-0 relative h-48 w-full bg-gray-100 block">
                                    @if($post->featured_image)
                                        <img class="h-full w-full object-cover" src="{{ Storage::url($post->featured_image) }}"
                                            alt="{{ $post->title }}">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-indigo-50 text-indigo-200">
                                            <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div>
                                    @endif
                                    @if($post->category)
                                        <div
                                            class="absolute top-4 left-4 bg-indigo-600/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                                            {{ $post->category->name }}
                                        </div>
                                    @endif
                                </a>
                                <div class="flex-1 p-6 flex flex-col justify-between">
                                    <div class="flex-1">
                                        <a href="{{ route('public.blog.show', $post->slug) }}" class="block mt-2">
                                            <h3
                                                class="text-xl font-bold text-gray-900 line-clamp-2 hover:text-indigo-600 transition-colors">
                                                {{ $post->title }}
                                            </h3>
                                            <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                                            </p>
                                        </a>
                                    </div>
                                    <div class="mt-6 flex items-center justify-between">
                                        <div class="text-sm text-gray-400 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                                                {{ $post->published_at->format('M d, Y') }}
                                            </time>
                                        </div>
                                        <a href="{{ route('public.blog.show', $post->slug) }}"
                                            class="text-indigo-600 font-medium hover:text-indigo-800 text-sm flex items-center">
                                            Read More
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-24 bg-gray-50 rounded-2xl border border-gray-200">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No posts found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if($category)
                                There are currently no blog posts published in this category.
                            @else
                                We haven't published any blog posts yet. Check back soon!
                            @endif
                        </p>
                        @if($category)
                            <div class="mt-6">
                                <a href="{{ route('public.blog.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    View All Posts
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/4 space-y-8">
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        Categories
                    </h3>
                    @if($categories->count() > 0)
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('public.blog.index') }}"
                                    class="flex items-center justify-between text-gray-600 hover:text-indigo-600 font-medium transition-colors {{ !$category ? 'text-indigo-600' : '' }}">
                                    All Posts
                                </a>
                            </li>
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('public.blog.index', ['category' => $cat->slug]) }}"
                                        class="flex items-center justify-between text-gray-600 hover:text-indigo-600 font-medium transition-colors {{ $category === $cat->slug ? 'text-indigo-600 font-bold' : '' }}">
                                        <span>{{ $cat->name }}</span>
                                        <span
                                            class="bg-gray-200 text-gray-600 py-0.5 px-2 rounded-full text-xs font-bold">{{ $cat->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">No categories found.</p>
                    @endif
                </div>

                <div class="bg-indigo-600 rounded-2xl p-6 text-white text-center shadow-lg shadow-indigo-600/20">
                    <h3 class="text-lg font-bold mb-2">Ready to Upgrade Your Invoicing?</h3>
                    <p class="text-indigo-100 text-sm mb-6">Create professional invoices in seconds and get paid faster.
                    </p>
                    <a href="{{ route('register') }}"
                        class="block w-full bg-white text-indigo-600 font-bold py-2 px-4 rounded-xl hover:bg-gray-50 transition-colors">
                        Create Free Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>