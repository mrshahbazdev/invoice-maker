<div class="max-w-7xl mx-auto space-y-6">
    <div class="adm-head">
        <div>
            <div class="adm-breadcrumb">
                <a href="{{ route('admin.blog.index') }}">Blog</a>
                <span>/</span>
                <h2 class="adm-title" style="font-size: 26px;">Categories</h2>
            </div>
            <p class="adm-sub">Manage topics and sections for your blog.</p>
        </div>
        <button wire:click="createCategory" class="adm-btn adm-btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Category
        </button>
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

    @if (session()->has('error'))
        <div class="adm-flash is-error">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="adm-card">
        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-center">Posts</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <div class="adm-cell-title">{{ $category->name }}</div>
                                @if($category->description)
                                    <div class="text-sm text-gray-500 mt-1 truncate max-w-xs">{{ $category->description }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="adm-code">{{ $category->slug }}</span>
                            </td>
                            <td class="text-center">
                                <span
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none {{ $category->posts_count > 0 ? 'text-brand-400 bg-brand-400/10' : 'text-gray-500 bg-gray-700' }} rounded-full">
                                    {{ $category->posts_count }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <button wire:click="editCategory({{ $category->id }})" class="adm-icon-btn">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteCategory({{ $category->id }})"
                                        wire:confirm="Are you sure you want to delete this category?"
                                        class="adm-icon-btn is-danger {{ $category->posts_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $category->posts_count > 0 ? 'disabled' : '' }}>
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
                            <td colspan="4" class="adm-empty">
                                No categories found. Create your first category to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit/Create Modal overlay -->
    @if($editingCategory)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="cancelEdit" class="adm-modal-backdrop" aria-hidden="true">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="adm-modal-panel inline-block align-bottom text-left transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="saveCategory">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4" style="border-bottom: 1px solid var(--adm-border);">
                            <h3 class="text-lg leading-6 font-bold text-white mb-6" id="modal-title">
                                {{ $editingCategory === 'new' ? 'Create New Category' : 'Edit Category' }}
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="adm-label">Name</label>
                                    <input type="text" wire:model.live.debounce.500ms="name" class="adm-input" required>
                                    @error('name') <span class="adm-error">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="adm-label">Slug (URL
                                        identifier)</label>
                                    <input type="text" wire:model="slug" class="adm-input mono" required>
                                    @error('slug') <span class="adm-error">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="adm-label">Description
                                        (Optional)</label>
                                    <textarea wire:model="description" rows="3" class="adm-input"></textarea>
                                    @error('description') <span class="adm-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="adm-modal-foot">
                            <button type="submit" class="adm-btn adm-btn-primary">
                                Save Category
                            </button>
                            <button type="button" wire:click="cancelEdit" class="adm-btn adm-btn-secondary">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
