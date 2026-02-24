<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class Show extends Component
{
    // Profile Update
    public string $name = '';
    public string $email = '';

    // Password Update
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Two-Factor
    public bool $showingQrCode = false;
    public bool $showingRecoveryCodes = false;
    public string $setupKey = '';
    public string $qrCodeSvg = '';
    public string $setupCode = '';
    public array $recoveryCodes = [];

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        session()->flash('profile_message', __('Profile information updated successfully.'));
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('The provided password does not match your current password.'),
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($this->password),
        ])->save();

        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('password_message', __('Password updated successfully.'));
    }

    public function enableTwoFactorAuthentication()
    {
        $google2fa = new Google2FA();
        $user = Auth::user();

        $this->setupKey = $google2fa->generateSecretKey();
        $this->qrCodeSvg = QrCode::size(200)->generate(
            $google2fa->getQRCodeUrl(config('app.name'), $user->email, $this->setupKey)
        );

        $this->showingQrCode = true;
        $this->showingRecoveryCodes = false;
    }

    public function confirmTwoFactorAuthentication()
    {
        $this->validate([
            'setupCode' => 'required|string',
        ]);

        $google2fa = new Google2FA();

        if (!$google2fa->verifyKey($this->setupKey, $this->setupCode)) {
            throw ValidationException::withMessages([
                'setupCode' => __('The provided code was invalid. Please scan the QR code and try again.'),
            ]);
        }

        $user = Auth::user();
        $user->forceFill([
            'two_factor_secret' => $this->setupKey,
            'two_factor_recovery_codes' => $this->generateRecoveryCodes(),
            'two_factor_confirmed_at' => now(),
        ])->save();

        $this->showingQrCode = false;
        $this->showingRecoveryCodes = true;
        $this->recoveryCodes = $user->two_factor_recovery_codes;
        $this->setupCode = '';

        session()->flash('two_factor_message', __('Two-factor authentication is now enabled.'));
    }

    public function showRecoveryCodes()
    {
        $this->recoveryCodes = Auth::user()->two_factor_recovery_codes ?? [];
        $this->showingRecoveryCodes = true;
    }

    public function regenerateRecoveryCodes()
    {
        $user = Auth::user();
        $user->forceFill([
            'two_factor_recovery_codes' => $this->generateRecoveryCodes(),
        ])->save();

        $this->recoveryCodes = $user->two_factor_recovery_codes;
        session()->flash('two_factor_message', __('Recovery codes have been regenerated.'));
    }

    public function disableTwoFactorAuthentication()
    {
        $user = Auth::user();
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        $this->showingQrCode = false;
        $this->showingRecoveryCodes = false;

        session()->flash('two_factor_message', __('Two-factor authentication has been disabled.'));
    }

    protected function generateRecoveryCodes()
    {
        return collect(range(1, 8))->map(function () {
            return Str::random(10) . '-' . Str::random(10);
        })->toArray();
    }

    public function render()
    {
        return view('livewire.profile.show');
    }
}
