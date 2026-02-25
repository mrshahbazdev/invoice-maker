<div>
 <div class="text-center mb-8">
 <h1 class="text-2xl font-bold text-gray-900">{{ __('Forgot Password') }}</h1>
 <p class="text-gray-600 mt-2">{{ __('Enter your email to reset your password') }}</p>
 </div>

 @if (session('status') || $status)
 <div class="mb-4 font-medium text-sm text-green-600">
 {{ session('status') ?? $status }}
 </div>
 @endif

 <form wire:submit="sendResetLink">
 <div class="mb-4">
 <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
 <input type="email" wire:model="email"
 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent"
 placeholder="{{ __('you@example.com') }}">
 @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
 </div>

 <button type="submit" wire:loading.attr="disabled"
 class="w-full flex justify-center items-center bg-brand-600 text-white py-2 px-4 rounded-lg hover:bg-brand-700 transition duration-200 disabled:opacity-50">
 <svg wire:loading wire:target="sendResetLink" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
 viewBox="0 0 24 24">
 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
 <path class="opacity-75" fill="currentColor"
 d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
 </path>
 </svg>
 <span>{{ __('Send Password Reset Link') }}</span>
 </button>
 </form>

 <div class="mt-6 text-center">
 <p class="text-sm text-gray-600">
 <a href="{{ route('login') }}"
 class="text-brand-600 hover:text-brand-700 font-medium">{{ __('Back to sign in') }}</a>
 </p>
 </div>
</div>