<?php


namespace App\Http\Middleware;


use Closure;


class EnsureServiceToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('X-SERVICE-TOKEN');
        if (!$token || $token !== env('SERVICE_TOKEN')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}
