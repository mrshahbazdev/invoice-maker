<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllocoreAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $dbKey = \App\Models\Setting::get('allocore.api_key');
        $apiKey = $dbKey ?: config('allocore.api_key');

        if (!$apiKey) {
            return response()->json(['error' => 'Allocore integration not configured'], 503);
        }

        $provided = $request->header('X-Allocore-Api-Key');

        if (!$provided || !hash_equals($apiKey, $provided)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
