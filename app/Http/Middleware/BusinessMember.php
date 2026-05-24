<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BusinessMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is authenticated but does not have a business_id,
        // they are not considered a business member for this middleware's purpose.
        if (Auth::check() && !Auth::user()->business_id) {
            // If the user's role is 'client', redirect them to their client dashboard.
            // This prevents clients from accessing business-specific areas.
            if (Auth::user()->role === 'client') {
                return redirect()->route('client.dashboard');
            }

            // If the user is already on the business profile page, allow the request to proceed.
            // This prevents a redirection loop for owners who are trying to set up their business.
            if ($request->routeIs('business.profile')) {
                return $next($request);
            }

            // For any other authenticated user without a business_id (e.g., an owner setting up),
            // redirect them to the business profile to complete setup.
            return redirect()->route('business.profile')->with('error', 'Please complete your business setup.');
        }

        // If the user is a business member (authenticated and has a business_id),
        // or if they are not authenticated (and thus the check for business_id doesn't apply),
        // allow the request to proceed.
        return $next($request);
    }
}
