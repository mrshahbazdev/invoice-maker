<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        @if (session()->has('message'))
            <div class="adm-flash is-success" role="alert">
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <div class="adm-head">
            <div>
                <h2 class="adm-title">
                    {{ __('Theme Palettes') }}
                </h2>
            </div>
            <button wire:click="create()" class="adm-btn adm-btn-primary">
                {{ __('Add Theme') }}
            </button>
        </div>

        <div class="adm-card">
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th scope="col">
                                {{ __('Name') }}
                            </th>
                            <th scope="col">
                                {{ __('Color') }}
                            </th>
                            <th scope="col">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" class="text-right">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($themes as $theme)
                            <tr>
                                <td class="whitespace-nowrap text-sm font-medium text-white">
                                    {{ $theme->name }}
                                </td>
                                <td class="whitespace-nowrap text-sm text-gray-400">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded border border-gray-600"
                                            style="background-color: {{ $theme->primary_color }}"></div>
                                        <span>{{ strtoupper($theme->primary_color) }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap text-sm text-gray-400">
                                    <button wire:click="toggleActive({{ $theme->id }})"
                                        class="{{ $theme->is_active ? 'text-green-400 hover:text-green-300' : 'text-gray-400 hover:text-gray-300' }}">
                                        @if($theme->is_active)
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </button>
                                </td>
                                <td class="whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $theme->id }})"
                                        class="adm-link mr-3">{{ __('Edit') }}</button>
                                    <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $theme->id }})"
                                        class="adm-link adm-link-danger">{{ __('Delete') }}</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="adm-empty">
                                    No themes found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="adm-modal-backdrop" aria-hidden="true" wire:click="$set('isModalOpen', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="adm-modal-panel inline-block align-bottom text-left transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-white mb-4" id="modal-title">
                                {{ $editingThemeId ? __('Edit Theme') : __('Add Theme') }}
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="adm-label">{{ __('Name') }}</label>
                                    <input type="text" wire:model="name" id="name" class="adm-input"
                                        placeholder="e.g. Ocean Blue">
                                    @error('name') <span class="adm-error">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="primary_color" class="adm-label">{{ __('Primary Color (Hex)') }}</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="color" wire:model="primary_color"
                                            class="h-10 w-10 p-1 border border-r-0 rounded-l-md cursor-pointer"
                                            style="border-color: var(--adm-border-strong); background: var(--adm-inset);">
                                        <input type="text" wire:model="primary_color" id="primary_color"
                                            class="adm-input mono" style="border-radius: 0 10px 10px 0;"
                                            placeholder="#0ea5e9">
                                    </div>
                                    @error('primary_color') <span class="adm-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input wire:model="is_active" id="is_active" type="checkbox" class="adm-check">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_active" class="font-medium text-gray-300">{{ __('Enabled') }}</label>
                                        <p class="text-gray-500">
                                            {{ __('If disabled, users will not be able to select this theme.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="adm-modal-foot">
                            <button type="submit" class="adm-btn adm-btn-primary">
                                {{ __('Save') }}
                            </button>
                            <button type="button" wire:click="$set('isModalOpen', false)" class="adm-btn adm-btn-secondary">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
