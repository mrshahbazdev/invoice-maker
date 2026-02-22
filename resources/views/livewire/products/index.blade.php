@php $title = 'Products'; @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Products</h2>
            <p class="text-gray-600">Manage your product library</p>
        </div>
        <a href="{{ route('products.create') }}"
            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 text-center">
            + Add Product
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products..."
                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('name')">
                            Name
                            @if($sortBy === 'name')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Description</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Price</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Unit</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tax</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Inventory</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ Str::limit($product->description, 50) ?? '-' }}</td>
                            <td class="py-3 px-4 text-gray-900">
                                {{ auth()->user()->business->currency_symbol }}{{ number_format($product->price, 2) }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $product->unit }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $product->tax_rate }}%</td>
                            <td class="py-3 px-4">
                                @if($product->manage_stock)
                                    <span
                                        class="px-2 py-1 rounded text-xs font-semibold {{ $product->stock_quantity > 5 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->stock_quantity }} in stock
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                                    <button wire:click="delete({{ $product->id }})"
                                        wire:confirm="Are you sure you want to delete this product?"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500">
                                No products found. <a href="{{ route('products.create') }}"
                                    class="text-blue-600 hover:text-blue-700">Add your first product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t flex justify-between items-center">
                <span class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                </span>
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>