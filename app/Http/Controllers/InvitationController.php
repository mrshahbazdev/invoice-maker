<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController
{
    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if (!$invitation->isValid()) {
            return redirect()->route('login')->with('error', 'This invitation has expired or already been used.');
        }

        // Check if user is already logged in
        if (Auth::check()) {
            $user = Auth::user();

            // If user is already in another business, we might want to warn or just swap
            // For now, let's join them to this business
            $user->update([
                'business_id' => $invitation->business_id,
                'role' => $invitation->role,
            ]);

            $invitation->update(['accepted_at' => now()]);

            return redirect()->route('dashboard')->with('message', 'Joined ' . $invitation->business->name . ' successfully!');
        }

        // If not logged in, check if user exists by email
        $user = User::where('email', $invitation->email)->first();

        if ($user) {
            // User exists, redirect to login and tell them to join
            return redirect()->route('login', ['email' => $invitation->email])
                ->with('message', 'Please log in to join ' . $invitation->business->name . '.');
        }

        // New user, redirect to register with pre-filled email
        return redirect()->route('register', ['email' => $invitation->email, 'invitation_token' => $token])
            ->with('message', 'Welcome! Please create an account to join ' . $invitation->business->name . '.');
    }
}
