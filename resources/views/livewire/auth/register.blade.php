<div>
 <div class="auth-head">
 <h1 class="auth-title">{{ __('Create Account') }}</h1>
 <p class="auth-sub">{{ __('Start creating invoices today') }}</p>
 </div>

 <form wire:submit="register">
 <div class="auth-field">
 <label class="auth-label">{{ __('Full Name') }}</label>
 <input type="text" wire:model="name"
 class="auth-input"
 placeholder="{{ __('John Doe') }}">
 @error('name') <p class="auth-error">{{ $message }}</p> @enderror
 </div>

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

 <div class="auth-field">
 <label class="auth-label">{{ __('Confirm Password') }}</label>
 <input type="password" wire:model="password_confirmation"
 class="auth-input"
 placeholder="••••••••">
 @error('password_confirmation') <p class="auth-error">{{ $message }}</p> @enderror
 </div>

 <div class="auth-field-lg">
 <label class="auth-label">{{ __('Business Name') }}</label>
 <input type="text" wire:model="business_name"
 class="auth-input"
 placeholder="{{ __('Your Business Name') }}">
 @error('business_name') <p class="auth-error">{{ $message }}</p> @enderror
 </div>

 <button type="submit" wire:loading.attr="disabled"
 class="auth-btn">
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

 <div class="auth-foot">
 <p class="auth-inline">
 {{ __('Already have an account?') }}
 <a href="{{ route('login') }}" class="auth-link">{{ __('Sign in') }}</a>
 </p>
 </div>
</div>
