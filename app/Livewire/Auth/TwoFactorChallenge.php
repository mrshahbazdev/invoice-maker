<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use PragmaRX\Google2FA\Google2FA;
use Livewire\Component;
use App\Models\User;

class TwoFactorChallenge extends Component
{
 public string $code = '';
 public string $recovery_code = '';
 public bool $recovery = false;

 public function mount()
 {
 if (!session()->has('login.id')) {
 return redirect()->route('login');
 }
 }

 public function toggleRecovery()
 {
 $this->recovery = !$this->recovery;
 $this->code = '';
 $this->recovery_code = '';
 }

 public function verify()
 {
 $userId = session('login.id');

 // Group G: throttle 2FA challenge attempts (5/min per user+IP, decay only).
 $throttleKey = 'two-factor-challenge:' . $userId . '|' . request()->ip();
 if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
 $seconds = RateLimiter::availableIn($throttleKey);
 $field = $this->recovery ? 'recovery_code' : 'code';
 $this->addError($field, __('Too many attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]));
 return;
 }
 $user = User::find($userId);

 if (!$user) {
 return redirect()->route('login');
 }

 if ($this->recovery) {
 $this->validate(['recovery_code' => 'required|string']);

 $recoveryCodes = $user->two_factor_recovery_codes ?? [];
 if (!in_array($this->recovery_code, $recoveryCodes)) {
 RateLimiter::hit($throttleKey, 60);
 $this->addError('recovery_code', __('The provided recovery code is invalid.'));
 return;
 }

 // Remove used recovery code
 $user->two_factor_recovery_codes = array_values(array_diff($recoveryCodes, [$this->recovery_code]));
 $user->save();

 } else {
 $this->validate(['code' => 'required|string']);

 $google2fa = new Google2FA();
 $valid = $google2fa->verifyKey($user->two_factor_secret, $this->code);

 if (!$valid) {
 RateLimiter::hit($throttleKey, 60);
 $this->addError('code', __('The provided two-factor authentication code is invalid.'));
 return;
 }
 }

 RateLimiter::clear($throttleKey);
 $remember = session('login.remember', false);
 Auth::login($user, $remember);
 session()->forget(['login.id', 'login.remember']);
 session()->regenerate();

 if (Auth::user()->role === 'client') {
 $this->redirect(route('client.dashboard'), navigate: true);
 } else {
 $this->redirect(route('dashboard'), navigate: true);
 }
 }

 public function render()
 {
 return view('livewire.auth.two-factor-challenge')->layout('layouts.guest');
 }
}
