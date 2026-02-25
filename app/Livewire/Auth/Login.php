<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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

 if (Auth::validate(['email' => $this->email, 'password' => $this->password])) {
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

 if (Auth::user()->role === 'client') {
 $this->redirect(route('client.dashboard'), navigate: true);
 } else {
 $this->redirect(route('dashboard'), navigate: true);
 }
 }

 $this->addError('email', 'These credentials do not match our records.');
 }

 public function render()
 {
 return view('livewire.auth.login')->layout('layouts.guest');
 }
}
