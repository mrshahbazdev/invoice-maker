<div class="max-w-7xl mx-auto space-y-6">
    <div class="adm-head">
        <div>
            <h2 class="adm-title">Blog Posts</h2>
            <p class="adm-sub">Manage your website's articles and content.</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.blog.categories') }}" class="adm-btn adm-btn-secondary">
                Manage Categories
            </a>
            <a href="{{ route('admin.blog.create') }}" class="adm-btn adm-btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Write Post
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="adm-flash is-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="adm-card">
        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                <div class="adm-cell-title">{{ $post->title }}</div>
                                <div class="text-xs text-gray-500 mt-1 font-mono">/blog/{{ $post->slug }}</div>
                            </td>
                            <td>
                                @if($post->category)
                                    <span class="adm-badge is-gray">{{ $post->category->name }}</span>
                                @else
                                    <span class="text-gray-500 text-sm italic">Uncategorized</span>
                                @endif
                            </td>
                            <td>
                                @if($post->is_published)
                                    <span class="adm-badge is-green">
                                        Published
                                    </span>
                                @else
                                    <span class="adm-badge is-yellow">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="text-sm text-gray-400">
                                @if($post->is_published && $post->published_at)
                                    {{ $post->published_at->format('M d, Y') }}
                                @else
                                    {{ $post->created_at->format('M d, Y') }}
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.blog.edit', $post) }}" class="adm-icon-btn">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <button wire:click="deletePost({{ $post->id }})"
                                        wire:confirm="Are you sure you want to delete this post?"
                                        class="adm-icon-btn is-danger">
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
                            <td colspan="5" class="adm-empty">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                    </path>
                                </svg>
                                <p class="title">No posts published yet.</p>
                                <p class="sub">Get started by creating a new blog post.</p>
                                <a href="{{ route('admin.blog.create') }}" class="adm-btn adm-btn-primary adm-btn-sm mt-4">
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
