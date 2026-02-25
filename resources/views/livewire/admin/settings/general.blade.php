<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold font-heading text-white">{{ __('Global Settings') }}</h2>
        <p class="text-gray-400 mt-1">{{ __('Manage your platform\'s identity, logo, and favicon.') }}</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-6 sm:p-8">
        <form wire:submit="save" class="space-y-8">

            <div class="grid grid-cols-1 gap-6">
                <!-- Site Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Site Name') }}</label>
                    <input type="text" wire:model="site_name"
                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl focus:ring-brand-500 focus:border-brand-500 block px-4 py-3"
                        placeholder="Invoice Maker">
                    @error('site_name') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                    <!-- Site Logo -->
                    <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-700/50">
                        <label
                            class="block text-sm font-medium text-gray-300 mb-4">{{ __('Site Logo (Header)') }}</label>

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
                                <label
                                    class="cursor-pointer bg-gray-800 hover:bg-gray-700 border border-gray-600 px-4 py-2 rounded-lg text-sm font-medium text-white transition">
                                    <span>Upload Logo</span>
                                    <input type="file" wire:model="logo" class="hidden" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Recommended size: 200x50px (PNG, transparent background)</p>
                        @error('logo') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Favicon -->
                    <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-700/50">
                        <label class="block text-sm font-medium text-gray-300 mb-4">{{ __('Browser Favicon') }}</label>

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
                                <label
                                    class="cursor-pointer bg-gray-800 hover:bg-gray-700 border border-gray-600 px-4 py-2 rounded-lg text-sm font-medium text-white transition">
                                    <span>Upload Favicon</span>
                                    <input type="file" wire:model="favicon" class="hidden"
                                        accept="image/png, image/x-icon">
                                </label>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Must be a square image. Recommended: 32x32. (PNG or ICO)</p>
                        @error('favicon') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

            <div class="flex justify-end pt-4 border-t border-gray-700/50">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-xl font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 focus:ring-offset-gray-900 disabled:opacity-50 transition-colors shadow-lg shadow-brand-500/20">
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