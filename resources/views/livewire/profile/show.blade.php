<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-txmain leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Information -->
            <div class="p-4 sm:p-8 bg-card shadow sm:rounded-lg">
                <section class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-txmain">
                            {{ __('Profile Information') }}
                        </h2>
                        <p class="mt-1 text-sm text-txmain">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>
                    </header>

                    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
                        <div>
                            <label class="block font-medium text-sm text-txmain" for="name">{{ __('Name') }}</label>
                            <input wire:model="name" id="name" type="text"
                                class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm mt-1 block w-full"
                                required autocomplete="name" />
                            @error('name') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-txmain" for="email">{{ __('Email') }}</label>
                            <input id="email" type="email"
                                class="bg-page border-gray-300 rounded-md shadow-sm mt-1 block w-full text-gray-500 cursor-not-allowed"
                                value="{{ $email }}" disabled />
                            <p class="mt-1 text-xs text-gray-500">{{ __('Your email address cannot be changed.') }}</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save') }}
                            </button>

                            @if (session()->has('profile_message'))
                                <p class="text-sm text-txmain">{{ session('profile_message') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-card shadow sm:rounded-lg">
                <section class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-txmain">
                            {{ __('Update Password') }}
                        </h2>
                        <p class="mt-1 text-sm text-txmain">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>
                    </header>

                    <form wire:submit="updatePassword" class="mt-6 space-y-6">
                        <div>
                            <label class="block font-medium text-sm text-txmain"
                                for="current_password">{{ __('Current Password') }}</label>
                            <input wire:model="current_password" id="current_password" type="password"
                                class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm mt-1 block w-full"
                                autocomplete="current-password" />
                            @error('current_password') <span class="text-sm text-red-600 mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-txmain"
                                for="password">{{ __('New Password') }}</label>
                            <input wire:model="password" id="password" type="password"
                                class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm mt-1 block w-full"
                                autocomplete="new-password" />
                            @error('password') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-txmain"
                                for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                                class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm mt-1 block w-full"
                                autocomplete="new-password" />
                            @error('password_confirmation') <span
                            class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save') }}
                            </button>

                            @if (session()->has('password_message'))
                                <p class="text-sm text-txmain">{{ session('password_message') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            <!-- Two Factor Authentication -->
            <div class="p-4 sm:p-8 bg-card shadow sm:rounded-lg">
                <section class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-txmain">
                            {{ __('Two-Factor Authentication') }}
                        </h2>
                        <p class="mt-1 text-sm text-txmain">
                            {{ __('Add additional security to your account using two-factor authentication.') }}
                        </p>
                    </header>

                    <div class="mt-6">
                        @if (session()->has('two_factor_message'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('two_factor_message') }}
                            </div>
                        @endif

                        @if(!Auth::user()->two_factor_confirmed_at && !$showingQrCode)
                            <h3 class="text-lg font-medium text-txmain mb-3">
                                {{ __('You have not enabled two-factor authentication.') }}
                            </h3>
                            <button wire:click="enableTwoFactorAuthentication"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Enable') }}
                            </button>
                        @elseif($showingQrCode)
                            <h3 class="text-lg font-medium text-txmain mb-3">
                                {{ __('Finish enabling two-factor authentication.') }}
                            </h3>
                            <p class="text-sm text-txmain mb-4">
                                {{ __('To finish enabling two-factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                            </p>
                            <div class="p-4 bg-card inline-block mb-4">
                                {!! $qrCodeSvg !!}
                            </div>

                            <p class="text-sm font-semibold text-txmain mb-4">
                                {{ __('Setup Key') }}: {{ $setupKey }}
                            </p>

                            <div class="mt-4 max-w-sm">
                                <label class="block font-medium text-sm text-txmain"
                                    for="setupCode">{{ __('Code') }}</label>
                                <input wire:model="setupCode" id="setupCode" type="text"
                                    class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm mt-1 block w-full"
                                    autofocus />
                                @error('setupCode') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-4 flex gap-4">
                                <button wire:click="confirmTwoFactorAuthentication"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Confirm') }}
                                </button>
                                <button wire:click="disableTwoFactorAuthentication"
                                    class="inline-flex items-center px-4 py-2 bg-card border border-gray-300 rounded-md font-semibold text-xs text-txmain uppercase tracking-widest shadow-sm hover:bg-page focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        @else
                            <h3 class="text-lg font-medium text-txmain mb-3">
                                {{ __('You have enabled two-factor authentication.') }}
                            </h3>

                            @if($showingRecoveryCodes)
                                <div class="mt-4 max-w-xl text-sm text-txmain">
                                    <p class="font-semibold text-txmain mb-2">
                                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two-factor authentication device is lost.') }}
                                    </p>
                                    <div class="grid gap-1 max-w-xs p-4 bg-page rounded-lg">
                                        @foreach($recoveryCodes as $code)
                                            <div class="font-mono">{{ $code }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-5 flex gap-3">
                                @if(!$showingRecoveryCodes)
                                    <button wire:click="showRecoveryCodes"
                                        class="inline-flex items-center px-4 py-2 bg-card border border-gray-300 rounded-md font-semibold text-xs text-txmain uppercase tracking-widest shadow-sm hover:bg-page focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ __('Show Recovery Codes') }}
                                    </button>
                                @endif
                                @if($showingRecoveryCodes)
                                    <button wire:click="regenerateRecoveryCodes"
                                        class="inline-flex items-center px-4 py-2 bg-card border border-gray-300 rounded-md font-semibold text-xs text-txmain uppercase tracking-widest shadow-sm hover:bg-page focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ __('Regenerate Recovery Codes') }}
                                    </button>
                                @endif
                                <button
                                    wire:confirm="{{ __('Are you sure you want to disable two factor authentication?') }}"
                                    wire:click="disableTwoFactorAuthentication"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Disable') }}
                                </button>
                            </div>
                        @endif
                    </div>
                </section>
            </div>

            <!-- Theme Preferences Section -->
            <div class="p-4 sm:p-8 bg-card shadow sm:rounded-lg">
                <section class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-txmain">
                            {{ __('Theme Preferences') }}
                        </h2>
                        <p class="mt-1 text-sm text-txmain">
                            {{ __('Select a custom color palette for your account. This will change the primary color scheme of your dashboard.') }}
                        </p>
                    </header>

                    <div class="mt-6 mb-8 border-b border-gray-200 pb-8">
                        <h3 class="text-sm font-semibold text-txmain mb-4">{{ __('Suggested Combinations') }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @php
                                $presets = [
                                    ['name' => __('Midnight Dark'), 'brand' => '#6366f1', 'page' => '#030712', 'card' => '#111827', 'text' => '#f9fafb'],
                                    ['name' => __('Hacker Green'), 'brand' => '#10b981', 'page' => '#052e16', 'card' => '#064e3b', 'text' => '#dcfce7'],
                                    ['name' => __('Ocean Calm'), 'brand' => '#0ea5e9', 'page' => '#f0f9ff', 'card' => '#e0f2fe', 'text' => '#0c4a6e'],
                                    ['name' => __('Elegant Sepia'), 'brand' => '#b45309', 'page' => '#fefce8', 'card' => '#ffffff', 'text' => '#451a03'],
                                ];
                            @endphp
                            @foreach($presets as $preset)
                                <button type="button"
                                    wire:click="applyPreset('{{ $preset['brand'] }}', '{{ $preset['page'] }}', '{{ $preset['card'] }}', '{{ $preset['text'] }}')"
                                    class="flex flex-col items-start border border-gray-200 rounded-lg p-3 hover:ring-2 hover:ring-brand-500 transition-all shadow-sm group bg-card focus:outline-none text-left">
                                    <span class="text-xs font-semibold text-txmain mb-3">{{ $preset['name'] }}</span>
                                    <div
                                        class="flex items-center -space-x-2 relative w-full h-8 group-hover:space-x-1 transition-all">
                                        <div class="w-8 h-8 rounded-full shadow-md z-[40] border-2 border-white ring-1 ring-gray-900/5"
                                            style="background-color: {{ $preset['brand'] }};" title="Brand"></div>
                                        <div class="w-8 h-8 rounded-full shadow-md z-[30] border-2 border-white ring-1 ring-gray-900/5"
                                            style="background-color: {{ $preset['page'] }};" title="Page Background"></div>
                                        <div class="w-8 h-8 rounded-full shadow-md z-[20] border-2 border-white ring-1 ring-gray-900/5"
                                            style="background-color: {{ $preset['card'] }};" title="Card Background"></div>
                                        <div class="w-8 h-8 rounded-full shadow-md z-[10] border-2 border-white ring-1 ring-gray-900/5"
                                            style="background-color: {{ $preset['text'] }};" title="Text Color"></div>
                                    </div>
                                    <span
                                        class="text-[10px] text-gray-500 mt-2 font-medium">{{ __('Click to apply preset') }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <form wire:submit="updateThemeSettings" class="space-y-6">
                        @include('livewire.profile.theme-selector', ['label' => __('Brand Color (Buttons & Links)'), 'modelName' => 'theme_id', 'modelValue' => $theme_id, 'defaultHex' => '#6366f1'])
                        @include('livewire.profile.theme-selector', ['label' => __('Page Background Color'), 'modelName' => 'page_bg_color_id', 'modelValue' => $page_bg_color_id, 'defaultHex' => '#f9fafb'])
                        @include('livewire.profile.theme-selector', ['label' => __('Card Background Color'), 'modelName' => 'card_bg_color_id', 'modelValue' => $card_bg_color_id, 'defaultHex' => '#ffffff'])
                        @include('livewire.profile.theme-selector', ['label' => __('Text Color'), 'modelName' => 'text_color_id', 'modelValue' => $text_color_id, 'defaultHex' => '#1f2937'])

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save Theme') }}
                            </button>

                            @if (session()->has('theme_message'))
                                <p class="text-sm text-txmain">{{ session('theme_message') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            <!-- AI Configuration Section -->
            <div class="p-4 sm:p-8 bg-card shadow sm:rounded-lg">
                <section class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-txmain">
                            {{ __('AI Configuration') }}
                        </h2>
                        <p class="mt-1 text-sm text-txmain">
                            {{ __('Provide your own API keys to personalize your AI interactions. If left blank, the system will use the default global keys (if available).') }}
                        </p>
                    </header>

                    <form wire:submit="updateAiSettings" class="mt-6 space-y-6">
                        <div>
                            <label class="block font-medium text-sm text-txmain" for="default_ai_provider">
                                {{ __('Default AI Provider') }}
                            </label>
                            <select wire:model="default_ai_provider" id="default_ai_provider"
                                class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="openai">{{ __('OpenAI (ChatGPT)') }}</option>
                                <option value="anthropic">{{ __('Anthropic (Claude)') }}</option>
                            </select>
                            @error('default_ai_provider') <span class="text-sm text-red-600 mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-txmain" for="openai_api_key">
                                {{ __('OpenAI API Key') }}
                            </label>
                            <input wire:model="openai_api_key" id="openai_api_key" type="password" placeholder="sk-..."
                                class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm mt-1 block w-full" />
                            @error('openai_api_key') <span class="text-sm text-red-600 mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-txmain" for="anthropic_api_key">
                                {{ __('Anthropic API Key') }}
                            </label>
                            <input wire:model="anthropic_api_key" id="anthropic_api_key" type="password"
                                placeholder="sk-ant-..."
                                class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm mt-1 block w-full" />
                            @error('anthropic_api_key') <span class="text-sm text-red-600 mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save') }}
                            </button>

                            @if (session()->has('ai_message'))
                                <p class="text-sm text-txmain">{{ session('ai_message') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

        </div>
    </div>
</div>