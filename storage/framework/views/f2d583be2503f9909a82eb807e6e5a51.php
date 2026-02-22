<?php $title = 'Templates'; ?>

<div>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Invoice Templates</h2>
        <p class="text-gray-600">Customize your invoice templates</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div
                class="bg-white rounded-lg shadow overflow-hidden <?php echo e($template->is_default ? 'ring-2 ring-blue-500' : ''); ?>">
                <div class="h-32 flex items-center justify-center" style="background: <?php echo e($template->primary_color); ?>20;">
                    <div class="text-center">
                        <div class="text-3xl mb-2">📄</div>
                        <span class="text-sm font-medium"
                            style="color: <?php echo e($template->primary_color); ?>;"><?php echo e($template->name); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($template->is_default): ?>
                            <span class="ml-2 text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Default</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-sm text-gray-600 mb-4">
                        <p>Color: <span class="inline-block w-4 h-4 rounded"
                                style="background: <?php echo e($template->primary_color); ?>;"></span> <?php echo e($template->primary_color); ?>

                        </p>
                        <p>Font: <?php echo e(ucfirst($template->font_family)); ?></p>
                        <p>Logo: <?php echo e(ucfirst($template->logo_position)); ?></p>
                    </div>
                    <div class="flex justify-between">
                        <a href="<?php echo e(route('templates.edit', $template)); ?>"
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$template->is_default): ?>
                            <button wire:click="setDefault(<?php echo e($template->id); ?>)"
                                class="text-green-600 hover:text-green-700 text-sm font-medium">Set Default</button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12 text-gray-500">
                No templates found.
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\user\Downloads\menu-cto-build-a-complete-working-laravel-invoice-maker-saas-mvp-with\cto-hosted-r8vyv2gc-d0a517842801070857da350ef6450083d7abc79e\resources\views/livewire/templates/index.blade.php ENDPATH**/ ?>