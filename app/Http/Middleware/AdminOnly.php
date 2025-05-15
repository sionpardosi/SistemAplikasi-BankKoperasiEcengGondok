<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user terautentikasi
        if (!Auth::guard('sanctum')->check() && !Auth::check()) {
            return response()->json(['error' => 'Unauthorized. Please login first.'], 401);
        }

        $user = Auth::user() ?? Auth::guard('sanctum')->user();

        // Pastikan user memiliki role "admin"
        if ($user->utype !== 'ADM') {
            return response()->json(['error' => 'Access Denied. Admins only.'], 403);
        }

        return $next($request);
    }
}
