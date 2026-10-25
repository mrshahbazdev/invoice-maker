<div>
 <div class="auth-head">
 <h1 class="auth-title">{{ __('Two-Factor Authentication') }}</h1>
 <p class="auth-sub">
 @if($recovery)
 {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
 @else
 {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
 @endif
 </p>
 </div>

 <form wire:submit="verify">
 @if($recovery)
 <div class="auth-field">
 <label class="auth-label">{{ __('Recovery Code') }}</label>
 <input type="text" wire:model="recovery_code"
 class="auth-input"
 placeholder="{{ __('Emergency recovery code') }}">
 @error('recovery_code') <p class="auth-error">{{ $message }}</p> @enderror
 </div>
 @else
 <div class="auth-field">
 <label class="auth-label">{{ __('Authentication Code') }}</label>
 <input type="text" wire:model="code" inputmode="numeric" pattern="[0-9]*"
 class="auth-input auth-code"
 placeholder="XXXXXX">
 @error('code') <p class="auth-error">{{ $message }}</p> @enderror
 </div>
 @endif

 <div class="auth-row-end">
 <button type="button" wire:click="toggleRecovery"
 class="auth-toggle">
 @if($recovery)
 {{ __('Use an authentication code') }}
 @else
 {{ __('Use a recovery code') }}
 @endif
 </button>
 </div>

 <button type="submit" wire:loading.attr="disabled"
 class="auth-btn">
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
