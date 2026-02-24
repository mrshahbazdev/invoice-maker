<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile Information') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>
                    </header>

                    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700" for="name">{{ __('Name') }}</label>
                            <input wire:model="name" id="name" type="text"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                required autocomplete="name" />
                            @error('name') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700" for="email">{{ __('Email') }}</label>
                            <input wire:model="email" id="email" type="email"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                required autocomplete="username" />
                            @error('email') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save') }}
                            </button>

                            @if (session()->has('profile_message'))
                                <p class="text-sm text-gray-600">{{ session('profile_message') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Update Password') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>
                    </header>

                    <form wire:submit="updatePassword" class="mt-6 space-y-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700"
                                for="current_password">{{ __('Current Password') }}</label>
                            <input wire:model="current_password" id="current_password" type="password"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                autocomplete="current-password" />
                            @error('current_password') <span class="text-sm text-red-600 mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700"
                                for="password">{{ __('New Password') }}</label>
                            <input wire:model="password" id="password" type="password"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                autocomplete="new-password" />
                            @error('password') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700"
                                for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                autocomplete="new-password" />
                            @error('password_confirmation') <span
                            class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save') }}
                            </button>

                            @if (session()->has('password_message'))
                                <p class="text-sm text-gray-600">{{ session('password_message') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            <!-- Two Factor Authentication -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Two-Factor Authentication') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
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
                            <h3 class="text-lg font-medium text-gray-900 mb-3">
                                {{ __('You have not enabled two-factor authentication.') }}
                            </h3>
                            <button wire:click="enableTwoFactorAuthentication"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Enable') }}
                            </button>
                        @elseif($showingQrCode)
                            <h3 class="text-lg font-medium text-gray-900 mb-3">
                                {{ __('Finish enabling two-factor authentication.') }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ __('To finish enabling two-factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                            </p>
                            <div class="p-4 bg-white inline-block mb-4">
                                {!! $qrCodeSvg !!}
                            </div>

                            <p class="text-sm font-semibold text-gray-600 mb-4">
                                {{ __('Setup Key') }}: {{ $setupKey }}
                            </p>

                            <div class="mt-4 max-w-sm">
                                <label class="block font-medium text-sm text-gray-700"
                                    for="setupCode">{{ __('Code') }}</label>
                                <input wire:model="setupCode" id="setupCode" type="text"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    autofocus />
                                @error('setupCode') <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-4 flex gap-4">
                                <button wire:click="confirmTwoFactorAuthentication"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Confirm') }}
                                </button>
                                <button wire:click="disableTwoFactorAuthentication"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        @else
                            <h3 class="text-lg font-medium text-gray-900 mb-3">
                                {{ __('You have enabled two-factor authentication.') }}
                            </h3>

                            @if($showingRecoveryCodes)
                                <div class="mt-4 max-w-xl text-sm text-gray-600">
                                    <p class="font-semibold text-gray-900 mb-2">
                                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two-factor authentication device is lost.') }}
                                    </p>
                                    <div class="grid gap-1 max-w-xs p-4 bg-gray-100 rounded-lg">
                                        @foreach($recoveryCodes as $code)
                                            <div class="font-mono">{{ $code }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-5 flex gap-3">
                                @if(!$showingRecoveryCodes)
                                    <button wire:click="showRecoveryCodes"
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ __('Show Recovery Codes') }}
                                    </button>
                                @endif
                                @if($showingRecoveryCodes)
                                    <button wire:click="regenerateRecoveryCodes"
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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

        </div>
    </div>
</div>