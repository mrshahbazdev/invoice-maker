@php $title = __('Create Product'); @endphp

<div>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">{{ __('Create Product') }}</h2>
        <p class="text-gray-600">{{ __('Add a new product to your library') }}</p>
    </div>

    <div class="max-w-2xl">
        <form wire:submit="save" class="bg-white rounded-lg shadow p-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Product Name') }} *</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('Web Development Package') }}">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }}</label>
                <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('Describe your product or service...') }}"></textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Price') }} *</label>
                    <input type="number" step="0.01" wire:model="price"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0.00">
                    @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Unit') }}</label>
                    <input type="text" wire:model="unit"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="{{ __('unit') }}">
                    @error('unit') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Tax Rate') }} (%)</label>
                <input type="number" step="0.01" wire:model="tax_rate"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="0">
                @error('tax_rate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900">{{ __('Inventory Management') }}</h4>
                        <p class="text-xs text-gray-500">{{ __('Track stock levels and get warnings when low') }}</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="manage_stock" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                        </div>
                    </label>
                </div>

                @if($manage_stock)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Initial Stock Quantity') }}</label>
                        <input type="number" wire:model="stock_quantity"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="0">
                        @error('stock_quantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>

            <div class="flex justify-between">
                <a href="{{ route('products.index') }}"
                    class="text-gray-600 hover:text-gray-700 py-2 px-4 rounded-lg border border-gray-300">{{ __('Cancel') }}</a>
                <button type="submit"
                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                    {{ __('Create Product') }}
                </button>
            </div>
        </form>
    </div>
</div>