<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyRecaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip verification in testing environment
        if (app()->environment('testing')) {
            return $next($request);
        }

        // Verify reCAPTCHA
        if ($request->has('g-recaptcha-response')) {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip()
            ]);

            $body = $response->json();

            if ($body['success'] && $body['score'] >= 0.5 && $body['action'] === 'register') {
                return $next($request);
            }
        }

        return redirect()->back()
            ->withInput($request->except('password', 'password_confirmation'))
            ->with('error', 'Verifikasi keamanan gagal. Silakan coba lagi.');
    }
}
