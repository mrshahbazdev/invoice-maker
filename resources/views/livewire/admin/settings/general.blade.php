<div class="max-w-4xl mx-auto">
    <div class="adm-head">
        <div>
            <h2 class="adm-title">{{ __('Global Settings') }}</h2>
            <p class="adm-sub">{{ __('Manage your platform\'s identity, logo, and favicon.') }}</p>
        </div>
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

    <div class="adm-card">
        <form wire:submit="save" class="adm-card-body space-y-8">

            <div class="grid grid-cols-1 gap-6">
                <!-- Site Name -->
                <div>
                    <label class="adm-label">{{ __('Site Name') }}</label>
                    <input type="text" wire:model="site_name" class="adm-input" placeholder="Invoice Maker">
                    @error('site_name') <span class="adm-error">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                    <!-- Site Logo -->
                    <div class="adm-inset p-6">
                        <label class="adm-label" style="margin-bottom: 16px;">{{ __('Site Logo (Header)') }}</label>

                        <div class="flex items-center space-x-6 mb-4">
                            <div
                                class="h-16 w-32 bg-gray-800 rounded-lg flex items-center justify-center overflow-hidden border border-gray-700">
                                @if ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="max-h-full max-w-full object-contain">
                                @elseif($current_logo)
                                    <img src="{{ Storage::url($current_logo) }}"
                                        class="max-h-full max-w-full object-contain">
                                @else
                                    <span class="text-gray-500 text-sm">No Logo</span>
                                @endif
                            </div>
                            <div>
                                <label class="adm-btn adm-btn-secondary adm-btn-sm adm-file-btn">
                                    <span>Upload Logo</span>
                                    <input type="file" wire:model="logo" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <p class="adm-hint">Recommended size: 200x50px (PNG, transparent background)</p>
                        @error('logo') <span class="adm-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Favicon -->
                    <div class="adm-inset p-6">
                        <label class="adm-label" style="margin-bottom: 16px;">{{ __('Browser Favicon') }}</label>

                        <div class="flex items-center space-x-6 mb-4">
                            <div
                                class="h-16 w-16 bg-gray-800 rounded-lg flex items-center justify-center overflow-hidden border border-gray-700">
                                @if ($favicon)
                                    <img src="{{ $favicon->temporaryUrl() }}" class="max-h-full max-w-full object-contain">
                                @elseif($current_favicon)
                                    <img src="{{ Storage::url($current_favicon) }}"
                                        class="max-h-full max-w-full object-contain">
                                @else
                                    <span class="text-gray-500 text-xs">No Icon</span>
                                @endif
                            </div>
                            <div>
                                <label class="adm-btn adm-btn-secondary adm-btn-sm adm-file-btn">
                                    <span>Upload Favicon</span>
                                    <input type="file" wire:model="favicon" accept="image/png, image/x-icon">
                                </label>
                            </div>
                        </div>
                        <p class="adm-hint">Must be a square image. Recommended: 32x32. (PNG or ICO)</p>
                        @error('favicon') <span class="adm-error">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

            <div class="flex justify-end pt-4" style="border-top: 1px solid var(--adm-border);">
                <button type="submit" wire:loading.attr="disabled" class="adm-btn adm-btn-primary">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>
    </div>
</div>
