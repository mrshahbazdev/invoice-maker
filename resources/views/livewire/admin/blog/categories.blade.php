<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.blog.index') }}" class="text-brand-400 hover:text-brand-300">Blog</a>
                <span class="text-gray-500">/</span>
                <h2 class="text-2xl font-bold font-heading text-white">Categories</h2>
            </div>
            <p class="text-gray-400 mt-1">Manage topics and sections for your blog.</p>
        </div>
        <button wire:click="createCategory"
            class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold shadow-lg shadow-brand-500/20 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Category
        </button>
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

    @if (session()->has('error'))
        <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 border-b border-gray-700">
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider">Slug</th>
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider text-center">
                            Posts</th>
                        <th class="py-4 px-6 font-semibold text-sm text-gray-300 uppercase tracking-wider text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-700/20 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-white">{{ $category->name }}</div>
                                @if($category->description)
                                    <div class="text-sm text-gray-500 mt-1 truncate max-w-xs">{{ $category->description }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span
                                    class="bg-gray-900 border border-gray-700 text-gray-400 text-xs px-2 py-1 rounded font-mono">{{ $category->slug }}</span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none {{ $category->posts_count > 0 ? 'text-brand-400 bg-brand-400/10' : 'text-gray-500 bg-gray-700' }} rounded-full">
                                    {{ $category->posts_count }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <button wire:click="editCategory({{ $category->id }})"
                                        class="text-brand-400 hover:text-brand-300 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteCategory({{ $category->id }})"
                                        wire:confirm="Are you sure you want to delete this category?"
                                        class="text-red-400 hover:text-red-300 transition-colors {{ $category->posts_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
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
                            <td colspan="4" class="py-8 text-center text-gray-500">
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
                <div wire:click="cancelEdit"
                    class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-gray-800 border border-gray-700 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="saveCategory">
                        <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-700">
                            <h3 class="text-lg leading-6 font-bold text-white mb-6" id="modal-title">
                                {{ $editingCategory === 'new' ? 'Create New Category' : 'Edit Category' }}
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Name</label>
                                    <input type="text" wire:model.live.debounce.500ms="name"
                                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500"
                                        required>
                                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Slug (URL
                                        identifier)</label>
                                    <input type="text" wire:model="slug"
                                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 font-mono text-sm"
                                        required>
                                    @error('slug') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Description
                                        (Optional)</label>
                                    <textarea wire:model="description" rows="3"
                                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 text-sm"></textarea>
                                    @error('description') <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-gray-800 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl border-t border-gray-700">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-brand-600 text-base font-medium text-white hover:bg-brand-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                Save Category
                            </button>
                            <button type="button" wire:click="cancelEdit"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>