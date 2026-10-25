<div class="max-w-7xl mx-auto space-y-6">
    <div class="adm-head">
        <div>
            <h2 class="adm-title">Subscription Plans</h2>
            <p class="adm-sub">Manage pricing tiers, limits, and features.</p>
        </div>
        <button wire:click="createPlan" class="adm-btn adm-btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Plan
        </button>
    </div>

    @if (session()->has('message'))
        <div class="adm-flash is-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($plans as $plan)
            <div class="adm-card p-6 relative flex flex-col h-full {{ $plan->is_active ? '' : 'ring-1 ring-red-500/30' }}">
                @if(!$plan->is_active)
                    <div class="absolute top-0 right-0 mt-4 mr-4">
                        <span class="adm-badge is-red">Inactive</span>
                    </div>
                @endif

                <h3 class="text-xl font-bold text-white mb-1">{{ $plan->name }}</h3>
                <p class="text-sm text-gray-400 mb-4 font-mono">{{ $plan->slug }}</p>

                <div class="flex items-baseline space-x-2 mb-6 pb-4" style="border-bottom: 1px solid var(--adm-border);">
                    <span class="text-3xl font-extrabold text-white">{{ number_format($plan->price_monthly, 2) }}</span>
                    <span class="text-gray-400 font-medium">{{ $plan->currency }} / mo</span>
                </div>

                <div class="space-y-3 flex-1 mb-6">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Invoices</span>
                        <span
                            class="font-bold {{ $plan->max_invoices === null ? 'text-brand-400' : 'text-white' }}">{{ $plan->max_invoices === null ? 'Unlimited' : $plan->max_invoices }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Clients</span>
                        <span
                            class="font-bold {{ $plan->max_clients === null ? 'text-brand-400' : 'text-white' }}">{{ $plan->max_clients === null ? 'Unlimited' : $plan->max_clients }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Products</span>
                        <span
                            class="font-bold {{ $plan->max_products === null ? 'text-brand-400' : 'text-white' }}">{{ $plan->max_products === null ? 'Unlimited' : $plan->max_products }}</span>
                    </div>
                </div>

                <button wire:click="editPlan({{ $plan->id }})" class="adm-btn adm-btn-secondary adm-btn-block">
                    Edit Plan
                </button>
            </div>
        @endforeach
    </div>

    <!-- Edit/Create Modal overlay -->
    @if($editingPlan)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="cancelEdit" class="adm-modal-backdrop" aria-hidden="true">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="adm-modal-panel inline-block align-bottom text-left transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit.prevent="savePlan">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4" style="border-bottom: 1px solid var(--adm-border);">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">
                                        {{ $editingPlan === 'new' ? 'Create New Plan' : 'Edit Plan' }}
                                    </h3>

                                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="adm-label">Plan Name</label>
                                            <input type="text" wire:model="name" class="adm-input" required>
                                            @error('name') <span class="adm-error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="adm-label">Slug
                                                (Identifier)</label>
                                            <input type="text" wire:model="slug" class="adm-input mono" required>
                                            @error('slug') <span class="adm-error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="adm-label">Monthly
                                                Price</label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" step="0.01" wire:model="price_monthly"
                                                    class="adm-input" style="padding-left: 28px;" required>
                                            </div>
                                            @error('price_monthly') <span class="adm-error">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="adm-label">Yearly Price</label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" step="0.01" wire:model="price_yearly"
                                                    class="adm-input" style="padding-left: 28px;" required>
                                            </div>
                                            @error('price_yearly') <span class="adm-error">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="sm:col-span-2 mt-4 pt-4" style="border-top: 1px solid var(--adm-border);">
                                            <h4 class="text-sm font-bold text-gray-300 mb-4">Limits (Empty = Unlimited)</h4>
                                        </div>

                                        <div>
                                            <label class="adm-label">Max Invoices</label>
                                            <input type="number" wire:model="max_invoices" class="adm-input"
                                                placeholder="Unlimited">
                                            @error('max_invoices') <span class="adm-error">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="adm-label">Max Clients</label>
                                            <input type="number" wire:model="max_clients" class="adm-input"
                                                placeholder="Unlimited">
                                            @error('max_clients') <span class="adm-error">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="adm-label">Max Products</label>
                                            <input type="number" wire:model="max_products" class="adm-input"
                                                placeholder="Unlimited">
                                            @error('max_products') <span class="adm-error">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="flex items-center mt-6">
                                            <input type="checkbox" wire:model="is_active" id="is_active"
                                                class="adm-check">
                                            <label for="is_active" class="ml-2 block text-sm font-medium text-white">Active
                                                (Visible to users)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="adm-modal-foot">
                            <button type="submit" class="adm-btn adm-btn-primary">
                                Save Plan
                            </button>
                            <button type="button" wire:click="cancelEdit" class="adm-btn adm-btn-secondary">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
