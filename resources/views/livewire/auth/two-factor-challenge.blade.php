<div>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">{{ __('Two-Factor Authentication') }}</h1>
        <p class="text-gray-600 mt-2">
            @if($recovery)
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            @else
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            @endif
        </p>
    </div>

    <form wire:submit="verify">
        @if($recovery)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Recovery Code') }}</label>
                <input type="text" wire:model="recovery_code"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('Emergency recovery code') }}">
                @error('recovery_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        @else
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Authentication Code') }}</label>
                <input type="text" wire:model="code" inputmode="numeric" pattern="[0-9]*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center tracking-widest text-lg"
                    placeholder="XXXXXX">
                @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        @endif

        <div class="mb-6 flex justify-end">
            <button type="button" wire:click="toggleRecovery"
                class="text-sm text-gray-600 hover:text-gray-900 underline">
                @if($recovery)
                    {{ __('Use an authentication code') }}
                @else
                    {{ __('Use a recovery code') }}
                @endif
            </button>
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="w-full flex justify-center items-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50">
            <svg wire:loading wire:target="verify" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span>{{ __('Log in') }}</span>
        </button>
    </form>
</div>