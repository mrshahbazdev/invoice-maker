<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Team extends Component
{
    public string $email = '';
    public string $role = 'viewer';

    protected $rules = [
        'email' => 'required|email|unique:invitations,email',
        'role' => 'required|in:admin,viewer',
    ];

    public function invite(): void
    {
        $this->authorize('manage-team', Auth::user()->business);

        $this->validate();

        // Check if user already exists in this business
        if (Auth::user()->business->users()->where('email', $this->email)->exists()) {
            $this->addError('email', 'This user is already a member of your team.');
            return;
        }

        Auth::user()->business->invitations()->create([
            'email' => $this->email,
            'role' => $this->role,
            'token' => Str::random(40),
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        $this->email = '';
        $this->role = 'viewer';

        session()->flash('message', 'Invitation sent successfully.');
    }

    public function cancelInvitation(int $id): void
    {
        $this->authorize('manage-team', Auth::user()->business);

        $invitation = Auth::user()->business->invitations()->findOrFail($id);
        $invitation->delete();

        session()->flash('message', 'Invitation cancelled.');
    }

    public function removeMember(int $id): void
    {
        $this->authorize('manage-team', Auth::user()->business);

        $user = Auth::user()->business->users()->findOrFail($id);

        if ($user->id === Auth::id()) {
            session()->flash('error', 'You cannot remove yourself.');
            return;
        }

        if ($user->isOwner()) {
            session()->flash('error', 'You cannot remove the business owner.');
            return;
        }

        $user->update(['business_id' => null, 'role' => 'user']);

        session()->flash('message', 'Team member removed.');
    }

    public function render()
    {
        $business = Auth::user()->business;
        $members = $business->users()->orderBy('role')->get();
        $invitations = $business->invitations()->whereNull('accepted_at')->where('expires_at', '>', now())->get();

        return view('livewire.settings.team', [
            'members' => $members,
            'invitations' => $invitations,
        ]);
    }
}
