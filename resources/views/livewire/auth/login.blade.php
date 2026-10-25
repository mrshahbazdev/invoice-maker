<div>
 <div class="auth-head">
 <h1 class="auth-title">{{ __('Welcome Back') }}</h1>
 <p class="auth-sub">{{ __('Sign in to your account') }}</p>
 </div>

 <form wire:submit="login">
 <div class="auth-field">
 <label class="auth-label">{{ __('Email') }}</label>
 <input type="email" wire:model="email"
 class="auth-input"
 placeholder="{{ __('you@example.com') }}">
 @error('email') <p class="auth-error">{{ $message }}</p> @enderror
 </div>

 <div class="auth-field">
 <label class="auth-label">{{ __('Password') }}</label>
 <input type="password" wire:model="password"
 class="auth-input"
 placeholder="••••••••">
 @error('password') <p class="auth-error">{{ $message }}</p> @enderror
 </div>

 <div class="auth-row-between">
 <label class="auth-check-label">
 <input type="checkbox" wire:model="remember"
 class="auth-check">
 <span class="auth-inline">{{ __('Remember me') }}</span>
 </label>
 <a href="{{ route('password.request') }}" class="auth-link auth-inline">
 {{ __('Forgot password?') }}
 </a>
 </div>

 <button type="submit" wire:loading.attr="disabled"
 class="auth-btn">
 <svg wire:loading wire:target="login" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
 viewBox="0 0 24 24">
 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
 <path class="opacity-75" fill="currentColor"
 d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
 </path>
 </svg>
 <span>{{ __('Sign In') }}</span>
 </button>
 </form>

 <div class="auth-foot">
 <p class="auth-inline">
 {{ __("Don't have an account?") }}
 <a href="{{ route('register') }}"
 class="auth-link">{{ __('Sign up') }}</a>
 </p>
 </div>

 </div>
</div>
