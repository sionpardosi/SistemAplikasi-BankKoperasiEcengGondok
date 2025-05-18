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

        // Periksa apakah response reCAPTCHA ada
        if (!$request->has('g-recaptcha-response') || empty($request->input('g-recaptcha-response'))) {
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['g-recaptcha-response' => 'Silakan verifikasi bahwa Anda bukan robot.']);
        }

        // Verifikasi reCAPTCHA secara manual menggunakan HTTP request
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('NOCAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        $body = $response->json();

        // Jika verifikasi berhasil
        if (isset($body['success']) && $body['success']) {
            return $next($request);
        }

        // Jika verifikasi gagal
        return redirect()->back()
            ->withInput($request->except('password', 'password_confirmation'))
            ->withErrors(['g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.']);
    }
}
