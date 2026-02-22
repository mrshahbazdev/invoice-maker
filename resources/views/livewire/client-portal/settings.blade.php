@component('layouts.app')
@slot('title', __('Profile Settings'))
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ __('Profile Settings') }}</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Update your personal information and security settings.') }}</p>
                </div>
                <div>
                    <a href="{{ route('client.dashboard') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        <svg class="mr-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Back to Dashboard') }}
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">{{ __('Personal Information') }}</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">{{ __("Update your account's profile information and email address.") }}</p>
                </div>

                <form wire:submit="updateProfile" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            
                            @if (session('profile_success'))
                                <div class="col-span-full rounded-md bg-green-50 p-4 ring-1 ring-green-500/20 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 font-medium text-sm text-green-800">{{ session('profile_success') }}</div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-span-full">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Full Name') }}</label>
                                <div class="mt-2">
                                    <input type="text" wire:model="name" id="name" autocomplete="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Email Address') }}</label>
                                <div class="mt-2">
                                    <input type="email" wire:model="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="address" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Billing Address') }}</label>
                                <div class="mt-2">
                                    <textarea wire:model="address" id="address" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"></textarea>
                                    @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8 bg-gray-50 rounded-b-xl">
                        <button type="submit" class="rounded-md bg-blue-600 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">{{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>

            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-8">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">{{ __('Update Password') }}</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                </div>

                <form wire:submit="updatePassword" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            
                            @if (session('password_success'))
                                <div class="col-span-full rounded-md bg-green-50 p-4 ring-1 ring-green-500/20 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 font-medium text-sm text-green-800">{{ session('password_success') }}</div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-span-full">
                                <label for="current_password" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Current Password') }}</label>
                                <div class="mt-2">
                                    <input type="password" wire:model="current_password" id="current_password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">{{ __('New Password') }}</label>
                                <div class="mt-2">
                                    <input type="password" wire:model="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Confirm Password') }}</label>
                                <div class="mt-2">
                                    <input type="password" wire:model="password_confirmation" id="password_confirmation" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8 bg-gray-50 rounded-b-xl">
                        <button type="submit" class="rounded-md bg-blue-600 px-7 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">{{ __('Update Password') }}</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
@endcomponent
