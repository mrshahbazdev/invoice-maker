<?php $title = 'Clients'; ?>

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Clients</h2>
            <p class="text-gray-600">Manage your client list</p>
        </div>
        <a href="<?php echo e(route('clients.create')); ?>"
            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 text-center">
            + Add Client
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search clients..."
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
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Email</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Company</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Phone</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium text-gray-900"><?php echo e($client->name); ?></td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e($client->email ?? '-'); ?></td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e($client->company_name ?? '-'); ?></td>
                            <td class="py-3 px-4 text-gray-600"><?php echo e($client->phone ?? '-'); ?></td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="<?php echo e(route('clients.edit', $client)); ?>"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                                    <button wire:click="delete(<?php echo e($client->id); ?>)"
                                        wire:confirm="Are you sure you want to delete this client?"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                No clients found. <a href="<?php echo e(route('clients.create')); ?>"
                                    class="text-blue-600 hover:text-blue-700">Add your first client</a>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clients->hasPages()): ?>
            <div class="p-4 border-t flex justify-between items-center">
                <span class="text-sm text-gray-600">
                    Showing <?php echo e($clients->firstItem()); ?> to <?php echo e($clients->lastItem()); ?> of <?php echo e($clients->total()); ?> results
                </span>
                <?php echo e($clients->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\user\Downloads\menu-cto-build-a-complete-working-laravel-invoice-maker-saas-mvp-with\cto-hosted-r8vyv2gc-d0a517842801070857da350ef6450083d7abc79e\resources\views/livewire/clients/index.blade.php ENDPATH**/ ?>