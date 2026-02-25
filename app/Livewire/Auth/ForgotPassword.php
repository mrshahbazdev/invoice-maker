<?php namespace App\Livewire\Auth; use Illuminate\Support\Facades\Password;
use Livewire\Component; class ForgotPassword extends Component
{ public string $email = ''; public string $status = ''; #[\Livewire\Attributes\Layout('layouts.guest', ['title' => 'Forgot Password'])] public function render() { return view('livewire.auth.forgot-password'); } public function sendResetLink() { $this->validate([ 'email' => 'required|email' ]); $status = Password::broker()->sendResetLink( ['email' => $this->email] ); if ($status === Password::RESET_LINK_SENT) { $this->status = __($status); $this->email = ''; } else { $this->addError('email', __($status)); } }
}
