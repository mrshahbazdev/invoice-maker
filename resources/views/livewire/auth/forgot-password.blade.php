<div>
 <div class="auth-head">
 <h1 class="auth-title">{{ __('Forgot Password') }}</h1>
 <p class="auth-sub">{{ __('Enter your email to reset your password') }}</p>
 </div>

 @if (session('status') || $status)
 <div class="auth-status">
 {{ session('status') ?? $status }}
 </div>
 @endif

 <form wire:submit="sendResetLink">
 <div class="auth-field">
 <label class="auth-label">{{ __('Email') }}</label>
 <input type="email" wire:model="email"
 class="auth-input"
 placeholder="{{ __('you@example.com') }}">
 @error('email') <p class="auth-error">{{ $message }}</p> @enderror
 </div>

 <button type="submit" wire:loading.attr="disabled"
 class="auth-btn">
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

 <div class="auth-foot">
 <p class="auth-inline">
 <a href="{{ route('login') }}"
 class="auth-link">{{ __('Back to sign in') }}</a>
 </p>
 </div>
</div>
