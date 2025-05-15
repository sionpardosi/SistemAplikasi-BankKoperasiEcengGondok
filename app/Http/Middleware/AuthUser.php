<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user terautentikasi
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['error' => 'Unauthorized. Please login first.'], 401);
        }

        return $next($request);
    }
}
