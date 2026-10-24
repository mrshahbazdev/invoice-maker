<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class Login extends Component
{
 public string $email = '';
 public string $password = '';
 public bool $remember = false;

 protected array $rules = [
 'email' => 'required|email',
 'password' => 'required',
 ];

 public function login(): void
 {
 $this->validate();

 // Group G: throttle login attempts (5/min per email+IP, decay only, no permanent block).
 $throttleKey = 'login:' . strtolower($this->email) . '|' . request()->ip();
 if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
 $seconds = RateLimiter::availableIn($throttleKey);
 $this->addError('email', __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]));
 return;
 }

 if (Auth::validate(['email' => $this->email, 'password' => $this->password])) {
 RateLimiter::clear($throttleKey);
 $user = \App\Models\User::where('email', $this->email)->first();

 if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
 // Prepare 2FA session details
 session([
 'login.id' => $user->id,
 'login.remember' => $this->remember,
 ]);

 $this->redirect(route('two-factor.challenge'), navigate: true);
 return;
 }

 Auth::login($user, $this->remember);
 session()->regenerate();

 if (Auth::user()->is_super_admin) {
 $this->redirect(route('admin.dashboard'));
 return;
 }

 if (Auth::user()->role === 'client') {
 $this->redirect(route('client.dashboard'));
 } else {
 $this->redirect(route('dashboard'));
 }
 }

 RateLimiter::hit($throttleKey, 60);
 $this->addError('email', 'These credentials do not match our records.');
 }

 public function render()
 {
 return view('livewire.auth.login')->layout('layouts.guest');
 }
}
