<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;

class AuthenticateWithAuthService
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthorized: No token'], 401);
        }

        // Call Auth-Service using Docker service name
        $response = Http::withToken($token)
            ->post('http://auth-service:8000/api/validate');

        if (!$response->ok() || !$response['valid']) {
            return response()->json(['message' => 'Unauthorized: Invalid token'], 401);
        }

        // Attach user data to request
        $request->merge(['auth_user' => $response['payload']]);

        return $next($request);
    }
}
