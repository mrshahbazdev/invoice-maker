<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $business_name = '';
    public string $invitation_token = '';

    public function mount(): void
    {
        if (request()->has('email')) {
            $this->email = request()->get('email');
        }

        if (request()->has('invitation_token')) {
            $this->invitation_token = request()->get('invitation_token');

            $invitation = \App\Models\Invitation::where('token', $this->invitation_token)->first();
            if ($invitation && $invitation->isValid()) {
                $this->business_name = $invitation->business->name;
            }
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'business_name' => $this->invitation_token ? 'nullable' : 'required|string|max:255',
        ];
    }

    public function register(): void
    {
        $this->validate();

        $invitation = null;
        if ($this->invitation_token) {
            $invitation = \App\Models\Invitation::where('token', $this->invitation_token)->first();
        }

        $user = User::create([
            'business_id' => $invitation ? $invitation->business_id : null,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $invitation ? $invitation->role : User::ROLE_OWNER,
        ]);

        if (!$invitation) {
            $business = Business::create([
                'user_id' => $user->id,
                'name' => $this->business_name,
                'currency' => 'USD',
                'timezone' => 'UTC',
            ]);

            $user->update(['business_id' => $business->id]);
        } else {
            $invitation->update(['accepted_at' => now()]);
        }

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}
