<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImpersonateController
{
    public function leave(Request $request)
    {
        if ($request->session()->has('impersonated_by')) {
            $adminId = $request->session()->pull('impersonated_by');
            $admin = \App\Models\User::find($adminId);

            // Group G: only restore a session to a verified super-admin.
            // A forged or stale stored id must never yield an admin session.
            if (!$admin || !$admin->is_super_admin) {
                Log::warning('impersonation_leave_rejected', [
                    'stored_admin_id' => $adminId,
                    'current_user_id' => Auth::id(),
                    'ip' => $request->ip(),
                    'at' => now()->toIso8601String(),
                ]);
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login');
            }

            Log::info('impersonation_ended', [
                'admin_id' => $admin->id,
                'target_id' => Auth::id(),
                'ip' => $request->ip(),
                'at' => now()->toIso8601String(),
            ]);
            Auth::loginUsingId($adminId);
            return redirect()->route('admin.users.index');
        }

        return redirect()->route('dashboard');
    }
}
