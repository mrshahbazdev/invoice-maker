<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The credentials you entered are incorrect.'],
            ]);
        }

        // Group C2: a deactivated account must not receive a token. The password
        // is checked first (above) so this does not leak account status, and
        // only an explicitly false is_active rejects (null counts as active,
        // matching the web EnsureUserIsActive middleware).
        if ($user->is_active === false) {
            return response()->json(['message' => 'Your account has been deactivated.'], 403);
        }

        // Group C2 (safe fallback, NOT a full 2FA implementation): the web 2FA
        // flow is session-based (login.id + challenge page) and there is no API
        // challenge endpoint in this batch, so a 2FA-enabled user gets no token
        // at all until a proper API challenge step is built.
        if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
            return response()->json([
                'message' => 'Two-factor authentication is required. Please complete two-factor authentication on the web before using the API.',
                'two_factor_required' => true,
            ], 403);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'user' => $user->load('business'),
            'token' => $token,
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user()->load('business'));
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
