<?php

namespace App\Livewire\ClientPortal;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Livewire\Attributes\Layout;

class Settings extends Component
{
    public $name;
    public $email;
    public $address;
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->address = Auth::user()->clients()->first()->address ?? '';
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Keep client records in sync
        foreach ($user->clients as $client) {
            $client->update([
                'name' => $this->name,
                'email' => $this->email,
                'address' => $this->address,
            ]);
        }

        session()->flash('profile_success', 'Profile updated successfully.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('password_success', 'Password updated successfully.');
    }

    #[Layout('layouts.client')]
    public function render()
    {
        return view('livewire.client-portal.settings');
    }
}
