<div>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">{{ __('Create Account') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('Start creating invoices today') }}</p>
    </div>

    <form wire:submit="register">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Full Name') }}</label>
            <input type="text" wire:model="name"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="{{ __('John Doe') }}">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
            <input type="email" wire:model="email"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="{{ __('you@example.com') }}">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
            <input type="password" wire:model="password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="••••••••">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
            <input type="password" wire:model="password_confirmation"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="••••••••">
            @error('password_confirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Business Name') }}</label>
            <input type="text" wire:model="business_name"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="{{ __('Your Business Name') }}">
            @error('business_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="w-full flex justify-center items-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50">
            <svg wire:loading wire:target="register" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span>{{ __('Create Account') }}</span>
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ __('Sign in') }}</a>
        </p>
    </div>
</div>