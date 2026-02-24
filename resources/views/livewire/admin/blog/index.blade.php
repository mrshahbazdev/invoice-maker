<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold font-heading text-white">Blog Posts</h2>
            <p class="text-gray-400 mt-1">Manage your website's articles and content.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.blog.categories') }}"
                class="px-4 py-2 bg-gray-800 border border-gray-700 hover:bg-gray-700 text-white rounded-xl font-medium transition-all">
                Manage Categories
            </a>
            <a href="{{ route('admin.blog.create') }}"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-500/20 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Write Post
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 border-b border-gray-700">
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider">Title</th>
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-700/20 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-white">{{ $post->title }}</div>
                                <div class="text-xs text-gray-500 mt-1 font-mono">/blog/{{ $post->slug }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($post->category)
                                    <span
                                        class="bg-gray-900 border border-gray-700 text-gray-400 text-xs px-2 py-1 rounded">{{ $post->category->name }}</span>
                                @else
                                    <span class="text-gray-500 text-sm italic">Uncategorized</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($post->is_published)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                        Published
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-400">
                                @if($post->is_published && $post->published_at)
                                    {{ $post->published_at->format('M d, Y') }}
                                @else
                                    {{ $post->created_at->format('M d, Y') }}
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.blog.edit', $post) }}"
                                        class="text-indigo-400 hover:text-indigo-300 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <button wire:click="deletePost({{ $post->id }})"
                                        wire:confirm="Are you sure you want to delete this post?"
                                        class="text-red-400 hover:text-red-300 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-600 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                    </path>
                                </svg>
                                <p class="text-gray-400 font-medium">No posts published yet.</p>
                                <p class="text-gray-500 text-sm mt-1">Get started by creating a new blog post.</p>
                                <a href="{{ route('admin.blog.create') }}"
                                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                    Write Post
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>