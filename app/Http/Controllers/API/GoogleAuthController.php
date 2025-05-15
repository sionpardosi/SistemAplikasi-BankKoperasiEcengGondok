<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends BaseController
{
    /**
     * Redirect ke Google untuk login
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
        // return $this->sendResponse(['url' => Socialite::driver('google')->redirect()->getTargetUrl()], 'Login successful with Google.');

        // return response()->json([
        //     'url' => Socialite::driver('google')->redirect()
        // ]);
    }

    /**
     * Handle callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan gauth_id
            $user = User::where('gauth_id', $googleUser->id)->first();

            if (!$user) {
                // Buat user baru jika belum ada
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()), // Generate password random
                    'gauth_id' => $googleUser->id,
                    'gauth_type' => 'google',
                    'email_verified_at' => now(), // Tandai sebagai email terverifikasi
                ]);
            }

            // Buat token untuk autentikasi API
            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->sendResponse(['token' => $token, 'user' => $user], 'Login successful with Google.');
        } catch (Exception $e) {
            return $this->sendError('Google login failed.', ['error' => $e->getMessage()], 500);
        }
    }
}
