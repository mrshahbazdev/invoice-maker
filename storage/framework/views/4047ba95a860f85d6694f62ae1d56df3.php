<?php $title = 'Estimates'; ?>

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Estimates & Quotations</h2>
            <p class="text-gray-600">Manage your estimates and bids</p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('estimates.create')); ?>"
                class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 shadow-sm transition duration-200 text-center font-medium">
                + Create Estimate
            </a>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b flex flex-col md:flex-row gap-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search estimates..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <select wire:model.live="status"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('invoice_number')">
                            Estimate #
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'invoice_number'): ?>
                                <span><?php echo e($sortDirection === 'asc' ? '↑' : '↓'); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Client</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('invoice_date')">
                            Date
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'invoice_date'): ?>
                                <span><?php echo e($sortDirection === 'asc' ? '↑' : '↓'); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Expires</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Amount</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $estimates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estimate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-blue-600 font-medium">
                                <?php echo e($estimate->invoice_number); ?>

                            </td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e($estimate->client->name); ?></td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e($estimate->invoice_date->format('M d, Y')); ?></td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e($estimate->due_date->format('M d, Y')); ?></td>
                            <td class="py-3 px-4 text-gray-900 font-medium">
                                <?php echo e($estimate->currency_symbol); ?><?php echo e(number_format($estimate->grand_total, 2)); ?>

                            </td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full bg-<?php echo e($estimate->status_color); ?>-100 text-<?php echo e($estimate->status_color); ?>-700">
                                    <?php echo e(ucfirst($estimate->status)); ?>

                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="<?php echo e(route('estimates.show', $estimate)); ?>"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">View</a>
                                    <a href="<?php echo e(route('estimates.edit', $estimate)); ?>"
                                        class="text-amber-600 hover:text-amber-700 text-sm font-medium">Edit</a>
                                    <button wire:click="convertToInvoice(<?php echo e($estimate->id); ?>)"
                                        wire:confirm="Convert this estimate to a standard invoice?"
                                        class="text-green-600 hover:text-green-700 text-sm font-medium">Convert</button>
                                    <button wire:click="delete(<?php echo e($estimate->id); ?>)"
                                        wire:confirm="Are you sure you want to delete this estimate?"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500">
                                No estimates found. <a href="<?php echo e(route('estimates.create')); ?>"
                                    class="text-blue-600 hover:text-blue-700">Create your first estimate</a>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($estimates->hasPages()): ?>
            <div class="p-4 border-t flex justify-between items-center">
                <span class="text-sm text-gray-600">
                    Showing <?php echo e($estimates->firstItem()); ?> to <?php echo e($estimates->lastItem()); ?> of <?php echo e($estimates->total()); ?>

                    results
                </span>
                <?php echo e($estimates->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\user\Downloads\menu-cto-build-a-complete-working-laravel-invoice-maker-saas-mvp-with\cto-hosted-r8vyv2gc-d0a517842801070857da350ef6450083d7abc79e\resources\views/livewire/estimates/index.blade.php ENDPATH**/ ?>