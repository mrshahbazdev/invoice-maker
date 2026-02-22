<?php $title = 'Products'; ?>

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Products</h2>
            <p class="text-gray-600">Manage your product library</p>
        </div>
        <a href="<?php echo e(route('products.create')); ?>"
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'name'): ?>
                                <span><?php echo e($sortDirection === 'asc' ? '↑' : '↓'); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium text-gray-900"><?php echo e($product->name); ?></td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e(Str::limit($product->description, 50) ?? '-'); ?></td>
                            <td class="py-3 px-4 text-gray-900">
                                <?php echo e(auth()->user()->business->currency_symbol); ?><?php echo e(number_format($product->price, 2)); ?></td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e($product->unit); ?></td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e($product->tax_rate); ?>%</td>
                            <td class="py-3 px-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->manage_stock): ?>
                                    <span
                                        class="px-2 py-1 rounded text-xs font-semibold <?php echo e($product->stock_quantity > 5 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($product->stock_quantity); ?> in stock
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="<?php echo e(route('products.edit', $product)); ?>"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                                    <button wire:click="delete(<?php echo e($product->id); ?>)"
                                        wire:confirm="Are you sure you want to delete this product?"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500">
                                No products found. <a href="<?php echo e(route('products.create')); ?>"
                                    class="text-blue-600 hover:text-blue-700">Add your first product</a>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->hasPages()): ?>
            <div class="p-4 border-t flex justify-between items-center">
                <span class="text-sm text-gray-600">
                    Showing <?php echo e($products->firstItem()); ?> to <?php echo e($products->lastItem()); ?> of <?php echo e($products->total()); ?> results
                </span>
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\user\Downloads\menu-cto-build-a-complete-working-laravel-invoice-maker-saas-mvp-with\cto-hosted-r8vyv2gc-d0a517842801070857da350ef6450083d7abc79e\resources\views/livewire/products/index.blade.php ENDPATH**/ ?>