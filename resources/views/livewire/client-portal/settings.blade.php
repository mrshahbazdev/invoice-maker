<div>
 <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
 <div>
 <h2 class="text-xl font-extrabold leading-7 text-txmain sm:text-3xl sm:truncate sm:tracking-tight">
 {{ __('Profile Settings') }}
 </h2>
 <p class="mt-1 text-xs sm:text-sm text-gray-500">
 {{ __('Update your personal information and security settings.') }}
 </p>
 </div>
 <div class="flex-shrink-0">
 <a href="{{ route('client.dashboard') }}"
 class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-500 bg-brand-50 px-4 py-2 rounded-xl transition-all duration-200 shadow-sm shadow-brand-100">
 <svg class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
 <path fill-rule="evenodd"
 d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
 clip-rule="evenodd" />
 </svg>
 {{ __('Dashboard') }}
 </a>
 </div>
 </div>

 <div class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
 <div class="px-4 sm:px-0">
 <h2 class="text-base font-bold leading-7 text-txmain uppercase tracking-widest text-xs">
 {{ __('Personal Information') }}
 </h2>
 <p class="mt-2 text-sm leading-6 text-txmain">
 {{ __("Update your account's profile information and email address.") }}
 </p>
 </div>

 <form wire:submit="updateProfile"
 class="bg-card shadow-xl shadow-gray-200/50 ring-1 ring-gray-900/5 sm:rounded-2xl md:col-span-2 overflow-hidden">
 <div class="px-4 py-6 sm:p-8">
 <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

 @if (session('profile_success'))
 <div class="col-span-full rounded-xl bg-green-50 p-4 ring-1 ring-green-500/20 mb-4 animate-pulse">
 <div class="flex">
 <div class="flex-shrink-0">
 <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
 <path fill-rule="evenodd"
 d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
 clip-rule="evenodd" />
 </svg>
 </div>
 <div class="ml-3 font-bold text-sm text-green-800">{{ session('profile_success') }}</div>
 </div>
 </div>
 @endif

 <div class="col-span-full">
 <label for="name"
 class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">{{ __('Full Name') }}</label>
 <input type="text" wire:model="name" id="name" autocomplete="name"
 class="block w-full rounded-xl border-0 py-3 text-txmain shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm transition-all duration-200">
 @error('name') <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
 @enderror
 </div>

 <div class="col-span-full">
 <label for="email"
 class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">{{ __('Email Address') }}</label>
 <input type="email" wire:model="email" id="email" autocomplete="email"
 class="block w-full rounded-xl border-0 py-3 text-txmain shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm transition-all duration-200">
 @error('email') <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
 @enderror
 </div>

 <div class="col-span-full">
 <label for="address"
 class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">{{ __('Billing Address') }}</label>
 <textarea wire:model="address" id="address" rows="3"
 class="block w-full rounded-xl border-0 py-3 text-txmain shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm transition-all duration-200"></textarea>
 @error('address') <span
 class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
 @enderror
 </div>
 </div>
 </div>
 <div class="flex items-center justify-end gap-x-6 border-t border-gray-100 px-4 py-6 sm:px-8 bg-page/50">
 <button type="submit" wire:loading.attr="disabled"
 class="inline-flex items-center justify-center rounded-xl bg-brand-600 px-8 py-3 text-sm font-black text-white shadow-lg shadow-brand-600/20 hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 transition-all duration-200 active:scale-95 disabled:opacity-50">
 <svg wire:loading wire:target="updateProfile" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
 fill="none" viewBox="0 0 24 24">
 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
 </circle>
 <path class="opacity-75" fill="currentColor"
 d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
 </path>
 </svg>
 <span>{{ __('Save Changes') }}</span>
 </button>
 </div>
 </form>
 </div>

 <div class="py-12">
 <div class="border-t border-gray-200/60"></div>
 </div>

 <div class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
 <div class="px-4 sm:px-0">
 <h2 class="text-base font-bold leading-7 text-txmain uppercase tracking-widest text-xs">
 {{ __('Update Password') }}
 </h2>
 <p class="mt-2 text-sm leading-6 text-txmain">
 {{ __('Ensure your account is using a long, random password to stay secure.') }}
 </p>
 </div>

 <form wire:submit="updatePassword"
 class="bg-card shadow-xl shadow-gray-200/50 ring-1 ring-gray-900/5 sm:rounded-2xl md:col-span-2 overflow-hidden">
 <div class="px-4 py-6 sm:p-8">
 <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

 @if (session('password_success'))
 <div class="col-span-full rounded-xl bg-green-50 p-4 ring-1 ring-green-500/20 mb-4 animate-pulse">
 <div class="flex">
 <div class="flex-shrink-0">
 <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
 <path fill-rule="evenodd"
 d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
 clip-rule="evenodd" />
 </svg>
 </div>
 <div class="ml-3 font-bold text-sm text-green-800 text-bold">
 {{ session('password_success') }}
 </div>
 </div>
 </div>
 @endif

 <div class="col-span-full">
 <label for="current_password"
 class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">{{ __('Current Password') }}</label>
 <input type="password" wire:model="current_password" id="current_password"
 class="block w-full rounded-xl border-0 py-3 text-txmain shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm transition-all duration-200">
 @error('current_password') <span
 class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span> @enderror
 </div>

 <div class="col-span-full">
 <label for="password"
 class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">{{ __('New Password') }}</label>
 <input type="password" wire:model="password" id="password"
 class="block w-full rounded-xl border-0 py-3 text-txmain shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm transition-all duration-200">
 @error('password') <span
 class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span>
 @enderror
 </div>

 <div class="col-span-full">
 <label for="password_confirmation"
 class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">{{ __('Confirm Password') }}</label>
 <input type="password" wire:model="password_confirmation" id="password_confirmation"
 class="block w-full rounded-xl border-0 py-3 text-txmain shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm transition-all duration-200">
 </div>
 </div>
 </div>
 <div class="flex items-center justify-end gap-x-6 border-t border-gray-100 px-4 py-6 sm:px-8 bg-page/50">
 <button type="submit" wire:loading.attr="disabled"
 class="inline-flex items-center justify-center rounded-xl bg-brand-600 px-8 py-3 text-sm font-black text-white shadow-lg shadow-brand-600/20 hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 transition-all duration-200 active:scale-95 disabled:opacity-50">
 <svg wire:loading wire:target="updatePassword" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
 fill="none" viewBox="0 0 24 24">
 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
 </circle>
 <path class="opacity-75" fill="currentColor"
 d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
 </path>
 </svg>
 <span>{{ __('Update Password') }}</span>
 </button>
 </div>
 </form>
 </div>
</div>