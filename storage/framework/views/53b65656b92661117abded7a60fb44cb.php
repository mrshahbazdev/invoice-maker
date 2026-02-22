<?php $title = $invoice->isEstimate() ? 'View Estimate' : 'View Invoice'; ?>

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900"><?php echo e($invoice->isEstimate() ? 'Estimate' : 'Invoice'); ?> Details</h2>
            <p class="text-gray-600"><?php echo e($invoice->invoice_number); ?></p>
        </div>
        <div class="flex flex-wrap gap-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->status === 'draft'): ?>
                <button wire:click="markAsSent"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Mark as Sent
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($invoice->status, ['sent', 'overdue'])): ?>
                <button wire:click="markAsPaid"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Mark as Paid
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->status === 'sent' && $invoice->due_date->isPast()): ?>
                <button wire:click="markAsOverdue"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                    Mark as Overdue
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($invoice->status, ['draft', 'sent', 'overdue'])): ?>
                <button wire:click="cancelInvoice"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Cancel
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <a href="<?php echo e(route('invoices.download', $invoice)); ?>"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Download PDF
            </a>
            <button wire:click="sendEmail"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                Email <?php echo e($invoice->isEstimate() ? 'Estimate' : 'Invoice'); ?>

            </button>
            <div x-data="{ copied: false }" class="relative">
                <button
                    @click="navigator.clipboard.writeText('<?php echo e(\Illuminate\Support\Facades\URL::signedRoute('invoices.public.show', $invoice->id)); ?>'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span x-text="copied ? 'Copied!' : 'Share Link'"></span>
                </button>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->status === 'draft'): ?>
                <a href="<?php echo e($invoice->isEstimate() ? route('estimates.edit', $invoice) : route('invoices.edit', $invoice)); ?>"
                    class="bg-white text-gray-700 py-2 px-4 rounded-lg border border-gray-300 shadow-sm hover:bg-gray-50 transition duration-200 text-center font-medium">
                    Edit <?php echo e($invoice->isEstimate() ? 'Estimate' : 'Invoice'); ?>

                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->isEstimate() && $invoice->status !== 'cancelled'): ?>
                <button wire:click="convertToInvoice" wire:confirm="Convert this estimate to a standard invoice?"
                    class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 shadow-sm transition duration-200 text-center font-medium">
                    Convert to Invoice
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">From</h4>
                        <div>
                            <p class="font-semibold text-gray-900"><?php echo e($invoice->business->name); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->business->email): ?>
                            <p class="text-sm text-gray-600"><?php echo e($invoice->business->email); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->business->phone): ?>
                            <p class="text-sm text-gray-600"><?php echo e($invoice->business->phone); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->business->address): ?>
                                <p class="text-sm text-gray-600 whitespace-pre-line"><?php echo e($invoice->business->address); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3"><?php echo e($invoice->isEstimate() ? 'ESTIMATE' : 'INVOICE'); ?> TO</h4>
                        <div>
                            <p class="font-semibold text-gray-900"><?php echo e($invoice->client->name); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->client->company_name): ?>
                            <p class="text-sm text-gray-600"><?php echo e($invoice->client->company_name); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->client->email): ?>
                            <p class="text-sm text-gray-600"><?php echo e($invoice->client->email); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->client->phone): ?>
                            <p class="text-sm text-gray-600"><?php echo e($invoice->client->phone); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->client->address): ?>
                                <p class="text-sm text-gray-600 whitespace-pre-line"><?php echo e($invoice->client->address); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3"><?php echo e($invoice->isEstimate() ? 'ESTIMATE' : 'INVOICE'); ?> INFO</h4>
                <div class="space-y-1">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500"><?php echo e($invoice->isEstimate() ? 'Estimate' : 'Invoice'); ?> #:</span>
                        <span class="font-medium text-gray-900"><?php echo e($invoice->invoice_number); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500"><?php echo e($invoice->isEstimate() ? 'Estimate' : 'Invoice'); ?> Date:</span>
                        <span class="font-medium text-gray-900"><?php echo e($invoice->invoice_date->format('M d, Y')); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500"><?php echo e($invoice->isEstimate() ? 'Expiration' : 'Due'); ?> Date:</span>
                        <span class="font-medium text-gray-900"><?php echo e($invoice->due_date->format('M d, Y')); ?></span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 text-sm font-semibold text-gray-700">Description</th>
                                <th class="text-right py-3 text-sm font-semibold text-gray-700">Qty</th>
                                <th class="text-right py-3 text-sm font-semibold text-gray-700">Price</th>
                                <th class="text-right py-3 text-sm font-semibold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b">
                                    <td class="py-3">
                                        <p class="font-medium text-gray-900"><?php echo e($item->description); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->tax_rate > 0): ?>
                                        <p class="text-sm text-gray-500">Tax: <?php echo e($item->tax_rate); ?>%</p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="py-3 text-right text-gray-600"><?php echo e($item->quantity); ?></td>
                                    <td class="py-3 text-right text-gray-600">
                                        <?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($item->unit_price, 2)); ?>

                                    </td>
                                    <td class="py-3 text-right text-gray-900 font-medium">
                                        <?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($item->total, 2)); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span
                                class="font-medium"><?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($invoice->subtotal, 2)); ?></span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Tax:</span>
                            <span
                                class="font-medium"><?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($invoice->tax_total, 2)); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->discount > 0): ?>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Discount:</span>
                                <span
                                    class="font-medium text-red-600">-<?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($invoice->discount, 2)); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex justify-between py-2 border-t font-bold text-lg">
                            <span>Total:</span>
                            <span><?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($invoice->grand_total, 2)); ?></span>
                        </div>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->notes): ?>
                    <div class="mt-6 pt-6 border-t">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Notes</h4>
                        <p class="text-gray-600"><?php echo e($invoice->notes); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div class="flex items-center justify-between">
                    <span
                        class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-<?php echo e($invoice->status_color); ?>-100 text-<?php echo e($invoice->status_color); ?>-700">
                        <?php echo e(ucfirst($invoice->status)); ?>

                    </span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->last_reminder_sent_at): ?>
                        <span class="text-xs text-gray-500" title="Last automated reminder sent">
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <?php echo e($invoice->last_reminder_sent_at->diffForHumans()); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total:</span>
                        <span
                            class="font-medium"><?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($invoice->grand_total, 2)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Paid:</span>
                        <span
                            class="font-medium text-green-600"><?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($invoice->amount_paid, 2)); ?></span>
                    </div>
                    <div class="flex justify-between pt-2 border-t font-bold">
                        <span>Due:</span>
                        <span
                            class="<?php echo e($invoice->amount_due > 0 ? 'text-red-600' : 'text-green-600'); ?>"><?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($invoice->amount_due, 2)); ?></span>
                    </div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->amount_due > 0): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Record Payment</h3>
                    <form wire:submit="recordPayment">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                            <input type="number" step="0.01" wire:model="payment_amount"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0.00">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Method</label>
                            <select wire:model="payment_method"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="paypal">PayPal</option>
                                <option value="stripe">Stripe</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" wire:model="payment_date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                            <textarea wire:model="payment_notes" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                            Record Payment
                        </button>
                    </form>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->payments->count() > 0): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment History</h3>
                    <div class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex justify-between items-start pb-3 border-b last:border-0">
                                <div>
                                    <p class="font-medium">
                                        <?php echo e($invoice->currency_symbol); ?><?php echo e(number_format($payment->amount, 2)); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo e($payment->date->format('M d, Y')); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600"><?php echo e(ucfirst(str_replace('_', ' ', $payment->method))); ?></p>
                                    <button wire:click="deletePayment(<?php echo e($payment->id); ?>)" wire:confirm="Delete this payment?"
                                        class="text-xs text-red-600 hover:text-red-700">Delete</button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\Users\user\Downloads\menu-cto-build-a-complete-working-laravel-invoice-maker-saas-mvp-with\cto-hosted-r8vyv2gc-d0a517842801070857da350ef6450083d7abc79e\resources\views/livewire/invoices/show.blade.php ENDPATH**/ ?>