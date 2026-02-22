@php $title = __('Accounting Categories'); @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Accounting Categories') }}</h2>
            <p class="text-gray-600">{{ __('Manage categories and posting rules for your cash book.') }}</p>
        </div>
        <button wire:click="openModal()"
            class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 shadow-sm transition duration-200 font-medium">
            + {{ __('Add Category') }}
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Name') }}</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Type') }}</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Posting Rule') }}</th>
                    <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-gray-900 font-medium">{{ $category->name }}</td>
                        <td class="py-3 px-4">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold {{ $category->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst(__($category->type)) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-600 text-sm truncate max-w-xs" title="{{ $category->posting_rule }}">
                            {{ $category->posting_rule ?: __('No rule defined') }}
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex justify-end gap-3 text-sm">
                                <button wire:click="openModal({{ $category->id }})"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ __('Edit') }}
                                </button>
                                <button wire:click="delete({{ $category->id }})"
                                    wire:confirm="{{ __('Are you sure? This will not delete past entries but will remove the category for future ones.') }}"
                                    class="text-red-600 hover:text-red-800 font-medium">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500 italic">
                            {{ __('No categories found. Click "Add Category" to get started.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Category Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="text-xl font-bold text-gray-900">{{ $isEditing ? __('Edit Category') : __('Add Category') }}
                    </h3>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Category Name') }} *</label>
                        <input type="text" wire:model="name"
                            placeholder="{{ __('e.g. Office Supplies, SaaS, Client Fees') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Type') }}</label>
                        <select wire:model="type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="expense">{{ __('Expense (Ausgabe)') }}</option>
                            <option value="income">{{ __('Income (Einnahme)') }}</option>
                        </select>
                        @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Posting Rule (Buchungsregel)') }}</label>
                        <textarea wire:model="posting_rule" rows="3"
                            placeholder="{{ __('e.g. Requires receipt. Only deductible if business related.') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        @error('posting_rule') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="p-6 bg-gray-50 border-t flex justify-end gap-3">
                    <button wire:click="closeModal()" class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium">
                        {{ __('Cancel') }}
                    </button>
                    <button wire:click="save"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition font-bold">
                        {{ $isEditing ? __('Update Category') : __('Create Category') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>