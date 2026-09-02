@php $title = __('Accounting Categories'); @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-txmain">{{ __('Accounting Categories') }}</h2>
            <p class="text-txmain">{{ __('Manage categories, cost centers (Fix / Variable Kosten), and posting rules.') }}</p>
        </div>
        <button wire:click="openModal()"
            class="bg-brand-600 text-white py-2 px-6 rounded-lg hover:bg-brand-700 shadow-sm transition duration-200 font-medium">
            + {{ __('Add Category') }}
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-card rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b bg-page">
                    <th class="text-left py-3 px-4 text-sm font-semibold text-txmain">{{ __('Name') }}</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-txmain">{{ __('Account') }}</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-txmain">{{ __('Type') }}</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-txmain">{{ __('Cost Behavior') }}</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-txmain">{{ __('Posting Rule') }}</th>
                    <th class="text-right py-3 px-4 text-sm font-semibold text-txmain">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-page transition">
                        <td class="py-3 px-4 text-txmain font-medium">{{ $category->name }}</td>
                        <td class="py-3 px-4 text-txmain text-sm font-mono">{{ $category->booking_account ?: '-' }}</td>
                        <td class="py-3 px-4">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold {{ $category->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst(__($category->type)) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @if($category->type === 'expense')
                                @if(($category->cost_type ?? 'F') === 'F')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200" title="{{ __('Fixed Cost (Fixkosten)') }}">
                                        <span class="font-extrabold mr-1">F</span> {{ __('Fixed') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200" title="{{ __('Variable Cost (Variable Kosten)') }}">
                                        <span class="font-extrabold mr-1">V</span> {{ __('Variable') }}
                                    </span>
                                @endif
                            @else
                                <span class="text-xs text-gray-400 font-mono">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-txmain text-sm truncate max-w-xs" title="{{ $category->posting_rule }}">
                            {{ $category->posting_rule ?: __('No rule defined') }}
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex justify-end gap-3 text-sm">
                                <button wire:click="openModal({{ $category->id }})"
                                    class="text-brand-600 hover:text-brand-800 font-medium">
                                    {{ __('Edit') }}
                                </button>
                                <button wire:click="delete({{ $category->id }})"
                                    wire:confirm="{{ __('Are you sure? This will not delete past entries but will remove the category for future ones.') }}"
                                    class="text-red-600 hover:text-red-800 font-medium">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500 italic">
                            {{ __('No categories found. Click "Add Category" to get started.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Category Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div
                class="bg-card rounded-xl shadow-2xl w-full max-w-md flex flex-col max-h-[90vh] overflow-hidden transform transition-all">
                <div class="p-6 border-b flex justify-between items-center bg-page">
                    <h3 class="text-xl font-bold text-txmain">{{ $isEditing ? __('Edit Category') : __('Add Category') }}
                    </h3>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-txmain">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form wire:submit="save" class="flex flex-col flex-1 overflow-hidden">
                    <div class="p-6 space-y-4 overflow-y-auto flex-1 text-txmain">
                        <div>
                            <label class="block text-sm font-medium text-txmain mb-1">{{ __('Category Name') }} *</label>
                            <input type="text" wire:model="name"
                                placeholder="{{ __('e.g. Office Supplies, SaaS, Rent, Server Hosting') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-txmain mb-1">{{ __('Booking Account') }}
                                ({{ __('Number') }})</label>
                            <input type="text" wire:model="booking_account" placeholder="{{ __('e.g. 4200, 8400') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            @error('booking_account') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-txmain mb-1">{{ __('Type') }}</label>
                            <select wire:model.live="type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                                <option value="expense">{{ __('Expense (Ausgabe)') }}</option>
                                <option value="income">{{ __('Income (Einnahme)') }}</option>
                            </select>
                            @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        @if($type === 'expense')
                            <div>
                                <label class="block text-sm font-medium text-txmain mb-1">{{ __('Cost Behavior (Fix / Variable Kosten)') }} *</label>
                                <div class="grid grid-cols-2 gap-3 mt-1">
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer transition {{ $cost_type === 'F' ? 'border-brand-500 bg-brand-50/50 ring-2 ring-brand-500/20' : 'border-gray-200 hover:bg-page' }}">
                                        <input type="radio" wire:model="cost_type" value="F" class="text-brand-600 focus:ring-brand-500 mr-2">
                                        <div>
                                            <div class="font-bold text-sm text-txmain flex items-center gap-1">
                                                <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 text-xs font-black">F</span>
                                                {{ __('Fixed Costs') }}
                                            </div>
                                            <div class="text-[11px] text-gray-500">{{ __('Fixkosten (e.g. Rent, Subscriptions)') }}</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer transition {{ $cost_type === 'V' ? 'border-brand-500 bg-brand-50/50 ring-2 ring-brand-500/20' : 'border-gray-200 hover:bg-page' }}">
                                        <input type="radio" wire:model="cost_type" value="V" class="text-brand-600 focus:ring-brand-500 mr-2">
                                        <div>
                                            <div class="font-bold text-sm text-txmain flex items-center gap-1">
                                                <span class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-black">V</span>
                                                {{ __('Variable Costs') }}
                                            </div>
                                            <div class="text-[11px] text-gray-500">{{ __('Variable Kosten (e.g. Materials, Shipping)') }}</div>
                                        </div>
                                    </label>
                                </div>
                                @error('cost_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        <div>
                            <label
                                class="block text-sm font-medium text-txmain mb-1">{{ __('Posting Rule (Buchungsregel)') }}</label>
                            <textarea wire:model="posting_rule" rows="3"
                                placeholder="{{ __('e.g. Requires receipt. Only deductible if business related.') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
                            @error('posting_rule') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="p-6 bg-page border-t flex justify-end gap-3">
                        <button type="button" wire:click="closeModal()"
                            class="px-4 py-2 text-txmain hover:text-txmain font-medium">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 shadow-sm transition font-bold disabled:opacity-50">
                            <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>{{ __('Save Category') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
