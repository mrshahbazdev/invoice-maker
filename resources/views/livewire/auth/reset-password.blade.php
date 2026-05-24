<div>
 <div class="text-center mb-8">
 <h1 class="text-2xl font-bold text-txmain">{{ __('Reset Password') }}</h1>
 <p class="text-txmain mt-2">{{ __('Enter your new password below') }}</p>
 </div>

 @if (session('status') || $status)
 <div class="mb-4 font-medium text-sm text-green-600">
 {{ session('status') ?? $status }}
 </div>
 @endif

 <form wire:submit="resetPassword">
 <input type="hidden" wire:model="token">

 <div class="mb-4">
 <label class="block text-sm font-medium text-txmain mb-1">{{ __('Email') }}</label>
 <input type="email" wire:model="email"
 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent"
 readonly>
 @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
 </div>

 <div class="mb-4">
 <label class="block text-sm font-medium text-txmain mb-1">{{ __('New Password') }}</label>
 <input type="password" wire:model="password"
 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent"
 placeholder="••••••••">
 @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
 </div>

 <div class="mb-6">
 <label class="block text-sm font-medium text-txmain mb-1">{{ __('Confirm Password') }}</label>
 <input type="password" wire:model="password_confirmation"
 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent"
 placeholder="••••••••">
 </div>

 <button type="submit" wire:loading.attr="disabled"
 class="w-full flex justify-center items-center bg-brand-600 text-white py-2 px-4 rounded-lg hover:bg-brand-700 transition duration-200 disabled:opacity-50">
 <svg wire:loading wire:target="resetPassword" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
 viewBox="0 0 24 24">
 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
 <path class="opacity-75" fill="currentColor"
 d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
 </path>
 </svg>
 <span>{{ __('Reset Password') }}</span>
 </button>
 </form>
</div>