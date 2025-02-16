<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil token dari header Authorization
        $token = $request->bearerToken();
        if (!$token || $token !== env('API_TOKEN')) {
            return response()->json(['error' => 'Unauthorized'], 401);

        }

        return $next($request);
    }
}
