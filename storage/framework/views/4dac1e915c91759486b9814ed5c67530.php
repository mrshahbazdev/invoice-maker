<?php $title = 'Create Invoice'; ?>

<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quick): ?>
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">⚡ Quick Invoice</h2>
            <p class="text-gray-600">Create an invoice instantly</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                <select wire:model="currency"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="USD">USD - US Dollar</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="GBP">GBP - British Pound</option>
                    <option value="CAD">CAD - Canadian Dollar</option>
                    <option value="AUD">AUD - Australian Dollar</option>
                    <option value="JPY">JPY - Japanese Yen</option>
                    <option value="PKR">PKR - Pakistani Rupee</option>
                    <option value="INR">INR - Indian Rupee</option>
                    <option value="AED">AED - UAE Dirham</option>
                </select>
            </div>
            <div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Add Product Library Item</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="product_search"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Type to search products...">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->products->count() > 0): ?>
                            <div
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button wire:click="selectProduct(<?php echo e($product->id); ?>)"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                        <div class="font-medium"><?php echo e($product->name); ?></div>
                                        <div class="text-sm text-gray-500 flex justify-between items-center">
                                            <span><?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $product->price, 2)); ?> /
                                                <?php echo e($product->unit); ?></span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->manage_stock): ?>
                                                <span
                                                    class="text-xs font-semibold <?php echo e($product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                                    <?php echo e($product->stock_quantity); ?> in stock
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="space-y-4 mb-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-4 border rounded-lg bg-gray-50 grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-5">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Description *</label>
                            <input type="text" wire:model="items.<?php echo e($index); ?>.description"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Qty *</label>
                            <input type="number" step="0.01" wire:model.live="items.<?php echo e($index); ?>.quantity"
                                wire:change="updateItemTotal(<?php echo e($index); ?>)"
                                class="w-full px-3 py-2 border <?php echo e((isset($item['manage_stock']) && $item['manage_stock'] && $item['quantity'] > ($item['stock_quantity'] ?? 0)) ? 'border-red-500 bg-red-50 text-red-900 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500'); ?> rounded text-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['manage_stock']) && $item['manage_stock']): ?>
                                <p
                                    class="mt-1 text-[10px] <?php echo e($item['quantity'] > ($item['stock_quantity'] ?? 0) ? 'text-red-700 font-bold' : 'text-gray-500'); ?>">
                                    Stock: <?php echo e($item['stock_quantity'] ?? 0); ?>

                                </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Price *</label>
                            <input type="number" step="0.01" wire:model.live="items.<?php echo e($index); ?>.unit_price"
                                wire:change="updateItemTotal(<?php echo e($index); ?>)"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        <div class="md:col-span-3 flex justify-between items-center h-[38px]">
                            <div class="font-bold text-gray-900">
                                <?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $item['total'], 2)); ?>

                            </div>
                            <button wire:click="removeItem(<?php echo e($index); ?>)"
                                class="text-red-500 hover:text-red-700">Delete</button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <button wire:click="addItem" type="button" class="text-blue-600 text-sm font-medium hover:underline">+ Add
                    another item</button>
            </div>

            <div class="flex justify-between items-center border-t pt-4">
                <div class="text-2xl font-bold">Total:
                    <?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $this->totals['grand_total'], 2)); ?>

                </div>
                <button wire:click="save"
                    class="px-8 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow transition text-lg">
                    ✔ Create Invoice
                </button>
            </div>
        </div>
    <?php else: ?>

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Create Invoice</h2>
                <p class="text-gray-600">Step <?php echo e($step); ?> of 4</p>
            </div>
            <div class="flex space-x-2">
                <div class="h-2 w-8 rounded-full <?php echo e($step >= 1 ? 'bg-blue-600' : 'bg-gray-200'); ?>"></div>
                <div class="h-2 w-8 rounded-full <?php echo e($step >= 2 ? 'bg-blue-600' : 'bg-gray-200'); ?>"></div>
                <div class="h-2 w-8 rounded-full <?php echo e($step >= 3 ? 'bg-blue-600' : 'bg-gray-200'); ?>"></div>
                <div class="h-2 w-8 rounded-full <?php echo e($step >= 4 ? 'bg-blue-600' : 'bg-gray-200'); ?>"></div>
            </div>
        </div>

        <!-- Step 1: Select Client -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 1): ?>
            <div x-transition>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Client</h3>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Client *</label>
                        <select wire:model="client_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select a client...</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($client->company_name): ?>
                                (<?php echo e($client->company_name); ?>) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Don't have a client yet? <a href="<?php echo e(route('clients.create')); ?>"
                                class="text-blue-600 hover:text-blue-700">Create one</a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Step 2: Add Items -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 2): ?>
            <div x-transition>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Items</h3>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search Products</label>
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="product_search"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Type to search products...">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->products->count() > 0): ?>
                                <div
                                    class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button wire:click="selectProduct(<?php echo e($product->id); ?>)"
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                            <div class="font-medium"><?php echo e($product->name); ?></div>
                                            <div class="text-sm text-gray-500 flex justify-between items-center">
                                                <span><?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $product->price, 2)); ?> /
                                                    <?php echo e($product->unit); ?></span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->manage_stock): ?>
                                                    <span
                                                        class="text-xs font-semibold <?php echo e($product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                                        <?php echo e($product->stock_quantity); ?> in stock
                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="space-y-4 mb-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-4 border rounded-lg bg-gray-50">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-sm font-medium">Item <?php echo e($index + 1); ?></span>
                                    <button wire:click="removeItem(<?php echo e($index); ?>)"
                                        class="text-red-600 hover:text-red-700 text-sm">Remove</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                                        <textarea wire:model="items.<?php echo e($index); ?>.description" rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                        <input type="number" step="0.01" wire:model.live="items.<?php echo e($index); ?>.quantity"
                                            wire:change="updateItemTotal(<?php echo e($index); ?>)"
                                            class="w-full px-3 py-2 border <?php echo e((isset($item['manage_stock']) && $item['manage_stock'] && $item['quantity'] > ($item['stock_quantity'] ?? 0)) ? 'border-red-500 bg-red-50 text-red-900 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500'); ?> rounded-lg text-sm">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['manage_stock']) && $item['manage_stock']): ?>
                                            <p
                                                class="mt-1 text-xs <?php echo e($item['quantity'] > ($item['stock_quantity'] ?? 0) ? 'text-red-700 font-bold' : 'text-gray-500'); ?>">
                                                Current Stock: <?php echo e($item['stock_quantity'] ?? 0); ?>

                                            </p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price *</label>
                                        <input type="number" step="0.01" wire:model.live="items.<?php echo e($index); ?>.unit_price"
                                            wire:change="updateItemTotal(<?php echo e($index); ?>)"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tax Rate (%)</label>
                                        <input type="number" step="0.01" wire:model.live="items.<?php echo e($index); ?>.tax_rate"
                                            wire:change="updateItemTotal(<?php echo e($index); ?>)"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                                        <div class="px-3 py-2 bg-gray-100 rounded-lg text-sm font-medium">
                                            <?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $item['total'], 2)); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-8 text-gray-500">
                                No items added yet. Click "Add Item" to start.
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <button wire:click="addItem" type="button"
                        class="w-full border-2 border-dashed border-gray-300 rounded-lg py-3 text-gray-600 hover:border-blue-500 hover:text-blue-600 transition">
                        + Add Item
                    </button>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Step 3: Invoice Details -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 3): ?>
            <div x-transition>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Date *</label>
                            <input type="date" wire:model="invoice_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['invoice_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Due Date *</label>
                            <input type="date" wire:model="due_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Currency Override</label>
                            <select wire:model="currency"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="USD">USD - US Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="GBP">GBP - British Pound</option>
                                <option value="CAD">CAD - Canadian Dollar</option>
                                <option value="AUD">AUD - Australian Dollar</option>
                                <option value="JPY">JPY - Japanese Yen</option>
                                <option value="PKR">PKR - Pakistani Rupee</option>
                                <option value="INR">INR - Indian Rupee</option>
                                <option value="AED">AED - UAE Dirham</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount</label>
                            <input type="number" step="0.01" wire:model.live="discount"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0.00">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea wire:model="notes" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Payment terms, thank you note, etc..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                            <select wire:model="template_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select a template...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($t->id); ?>"><?php echo e($t->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['template_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Recurring Invoice</h4>
                                <p class="text-xs text-gray-500">Automatically generate this invoice on a schedule</p>
                            </div>
                            <button type="button" wire:click="$set('is_recurring', <?php echo e(!$is_recurring ? 'true' : 'false'); ?>)"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 <?php echo e($is_recurring ? 'bg-blue-600' : 'bg-gray-200'); ?>">
                                <span
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out <?php echo e($is_recurring ? 'translate-x-5' : 'translate-x-0'); ?>"></span>
                            </button>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_recurring): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-transition>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Frequency</label>
                                    <select wire:model="recurring_frequency"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['recurring_frequency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg self-end">
                                    <p class="text-xs text-blue-700 font-medium">
                                        <svg class="w-4 h-4 inline mr-1 mb-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        System will generate the first recurring copy today.
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Step 4: Review & Save -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step === 4): ?>
            <div x-transition>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Invoice</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Client:</span>
                            <span><?php echo e($this->clients->find($client_id)?->name); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Invoice Date:</span>
                            <span><?php echo e(\Carbon\Carbon::parse($invoice_date)->format('M d, Y')); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-medium">Due Date:</span>
                            <span><?php echo e(\Carbon\Carbon::parse($due_date)->format('M d, Y')); ?></span>
                        </div>

                        <div class="py-4">
                            <h4 class="font-semibold mb-2">Items:</h4>
                            <div class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex justify-between text-sm">
                                        <span><?php echo e($item['description']); ?> x <?php echo e($item['quantity']); ?></span>
                                        <span><?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $item['total'], 2)); ?></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span><?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $this->totals['subtotal'], 2)); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax:</span>
                                <span><?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $this->totals['tax_total'], 2)); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Discount:</span>
                                <span>-<?php echo e($this->currency_symbol); ?><?php echo e(number_format((float) $this->totals['discount'], 2)); ?></span>
                            </div>
                            <div class="flex justify-between font-bold text-lg pt-2 border-t">
                                <span>Total:</span>
                                <span><?php echo e(auth()->user()->business->currency_symbol); ?><?php echo e(number_format((float) $this->totals['grand_total'], 2)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Navigation Buttons -->
        <div class="mt-6 flex justify-between">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step > 1): ?>
                <button wire:click="previousStep"
                    class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    ← Previous
                </button>
            <?php else: ?>
                <div></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step < 4): ?>
                <button wire:click="nextStep" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Next →
                </button>
            <?php else: ?>
                <button wire:click="save" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Create Invoice
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\user\Downloads\menu-cto-build-a-complete-working-laravel-invoice-maker-saas-mvp-with\cto-hosted-r8vyv2gc-d0a517842801070857da350ef6450083d7abc79e\resources\views/livewire/invoices/create.blade.php ENDPATH**/ ?>