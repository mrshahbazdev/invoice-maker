<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'value', 'icon', 'color']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title', 'value', 'icon', 'color']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="bg-white rounded-lg shadow p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-widest"><?php echo e($title); ?></p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1"><?php echo e($value); ?></p>
        </div>
        <div class="p-3 rounded-xl bg-<?php echo e($color); ?>-50 border border-<?php echo e($color); ?>-100 shadow-sm text-<?php echo e($color); ?>-600">
            <?php echo $icon; ?>

        </div>
    </div>
</div><?php /**PATH C:\Users\user\Downloads\menu-cto-build-a-complete-working-laravel-invoice-maker-saas-mvp-with\cto-hosted-r8vyv2gc-d0a517842801070857da350ef6450083d7abc79e\resources\views/components/stats-card.blade.php ENDPATH**/ ?>