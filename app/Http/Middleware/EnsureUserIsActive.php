<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $rawStatus = $user->getRawOriginal('is_active');
            
            // Only deactivate if explicitly set to 0/false in the database (never when null or missing)
            if ($rawStatus !== null && ($rawStatus === 0 || $rawStatus === '0' || $rawStatus === false)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Your account has been suspended. Please contact support.');
            }
        }

        return $next($request);
    }
}
