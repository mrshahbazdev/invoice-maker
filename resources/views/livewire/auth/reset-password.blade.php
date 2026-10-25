<div>
 <div class="auth-head">
 <h1 class="auth-title">{{ __('Reset Password') }}</h1>
 <p class="auth-sub">{{ __('Enter your new password below') }}</p>
 </div>

 @if (session('status') || $status)
 <div class="auth-status">
 {{ session('status') ?? $status }}
 </div>
 @endif

 <form wire:submit="resetPassword">
 <input type="hidden" wire:model="token">

 <div class="auth-field">
 <label class="auth-label">{{ __('Email') }}</label>
 <input type="email" wire:model="email"
 class="auth-input"
 readonly>
 @error('email') <p class="auth-error">{{ $message }}</p> @enderror
 </div>

 <div class="auth-field">
 <label class="auth-label">{{ __('New Password') }}</label>
 <input type="password" wire:model="password"
 class="auth-input"
 placeholder="••••••••">
 @error('password') <p class="auth-error">{{ $message }}</p> @enderror
 </div>

 <div class="auth-field-lg">
 <label class="auth-label">{{ __('Confirm Password') }}</label>
 <input type="password" wire:model="password_confirmation"
 class="auth-input"
 placeholder="••••••••">
 </div>

 <button type="submit" wire:loading.attr="disabled"
 class="auth-btn">
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
