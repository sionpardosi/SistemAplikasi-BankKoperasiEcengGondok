<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    /**
     * Redirect ke Google untuk login
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('gauth_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {

                // Jika user ditemukan, update gauth_id jika perlu
                if (!$finduser->gauth_id) {
                    $finduser->update([
                        'gauth_id' => $user->id,
                        'gauth_type' => 'google',
                    ]);
                }
                Auth::login($finduser);
                $finduser->createToken('auth_token')->plainTextToken;

                return redirect()->route('home.index');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'gauth_id' => $user->id,
                    'gauth_type' => 'google',
                    'password' => Hash::make(uniqid()), // Generate password random
                    'email_verified_at' => now(), // Tandai sebagai email terverifikasi
                ]);

                Auth::login($newUser);

                $newUser->createToken('auth_token')->plainTextToken;

                return redirect()->route('home.index');
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
}
