@php $title = __('Record Expense'); @endphp

<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Record Expense') }}</h2>
            <p class="text-gray-600">{{ __('Enter your expense details and upload a receipt') }}</p>
        </div>
        <a href="{{ route('expenses.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Back to List') }}</a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <form wire:submit="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Date') }}</label>
                        <input type="date" wire:model="date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Amount') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">{{ Auth::user()->business->currency_symbol }}</span>
                            </div>
                            <input type="number" step="0.01" wire:model="amount"
                                class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0.00">
                        </div>
                        @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Category') }}</label>
                    <input type="text" wire:model="category" list="categories"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="{{ __('e.g. Travel, Office Supplies, Software') }}">
                    <datalist id="categories">
                        @foreach($recentCategories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                        <option value="Travel">{{ __('Travel') }}</option>
                        <option value="Office Supplies">{{ __('Office Supplies') }}</option>
                        <option value="Software">{{ __('Software') }}</option>
                        <option value="Marketing">{{ __('Marketing') }}</option>
                        <option value="Utilities">{{ __('Utilities') }}</option>
                        <option value="Rent">{{ __('Rent') }}</option>
                    </datalist>
                    @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }}</label>
                    <input type="text" wire:model="description"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="{{ __('What was this expense for?') }}">
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label
                        class="block text-sm font-medium text-gray-700 mb-1">{{ __('Receipt Image (Optional)') }}</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            @if ($receipt)
                                <div class="mb-4">
                                    <img src="{{ $receipt->temporaryUrl() }}"
                                        class="mx-auto h-32 w-auto rounded-lg shadow-sm">
                                </div>
                            @else
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>{{ __('Upload a file') }}</span>
                                    <input id="file-upload" wire:model="receipt" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">{{ __('or drag and drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF {{ __('up to 2MB') }}
                            </p>
                        </div>
                    </div>
                    @error('receipt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('expenses.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm transition">
                        {{ __('Save Expense') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>