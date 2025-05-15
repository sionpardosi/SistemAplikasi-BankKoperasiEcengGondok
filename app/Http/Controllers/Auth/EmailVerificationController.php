<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\EmailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    // Waktu kedaluwarsa untuk kode verifikasi (dalam menit)
    const EXPIRATION_TIME = 10;

    /**
     * Mengirimkan kode verifikasi ke email
     */
    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'regex:/^[0-9]{10,15}$/', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate verification code
        $token = EmailVerification::generateToken();
        $expiresAt = Carbon::now()->addMinutes(self::EXPIRATION_TIME);

        // Save verification data
        EmailVerification::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'password' => $request->password,
                'token' => $token,
                'expires_at' => $expiresAt
            ]
        );

        // Store timestamp in session
        $verificationTimestamp = time();
        Session::put('verification_timestamp', $verificationTimestamp);

        // Send email
        try {
            Mail::to($request->email)->send(new VerificationCodeMail($token, $expiresAt, $request->name));

            return redirect()->route('verification.form', ['email' => $request->email])
                ->with('success', 'Kode verifikasi telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengirim kode verifikasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan form untuk verifikasi kode
     */
    public function showVerificationForm(Request $request)
    {
        $email = $request->email;

        if (!$email) {
            return redirect()->route('register');
        }

        // If the verification timestamp doesn't exist in session, set it
        // This helps with the timer consistency on page refreshes
        if (!Session::has('verification_timestamp')) {
            // Check if there's a verification entry for this email
            $verification = EmailVerification::where('email', $email)->first();

            if ($verification && $verification->expires_at) {
                // Calculate timestamp from expires_at by subtracting expiration time
                $createdAt = $verification->expires_at->copy()->subMinutes(self::EXPIRATION_TIME);
                Session::put('verification_timestamp', $createdAt->timestamp);
            } else {
                // Fallback to current time
                Session::put('verification_timestamp', time());
            }
        }

        return view('auth.verify-email', compact('email'));
    }

    /**
     * Verifikasi kode yang dimasukkan user
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'verification_code' => ['required', 'string', 'size:6'],
        ]);

        $verification = EmailVerification::where('email', $request->email)
            ->where('token', $request->verification_code)
            ->first();

        if (!$verification) {
            return redirect()->back()
                ->with('error', 'Kode verifikasi tidak valid.')
                ->withInput();
        }

        if ($verification->isExpired()) {
            return redirect()->back()
                ->with('error', 'Kode verifikasi sudah kedaluwarsa. Silakan minta kode baru.')
                ->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $verification->name,
            'email' => $verification->email,
            'mobile' => $verification->mobile,
            'password' => Hash::make($verification->password),
            'email_verified_at' => now(), // Langsung verifikasi email
        ]);

        // Delete verification entry
        $verification->delete();

        // Clear verification timestamp from session
        Session::forget('verification_timestamp');

        // Log the user in
        auth()->login($user);

        return redirect()->route('home.index')
            ->with('success', 'Pendaftaran berhasil! Akun Anda telah diverifikasi.');
    }

    /**
     * Kirim ulang kode verifikasi
     */
    public function resendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $verification = EmailVerification::where('email', $request->email)->first();

        if (!$verification) {
            return redirect()->route('register')
                ->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // Generate new verification code
        $token = EmailVerification::generateToken();
        $expiresAt = Carbon::now()->addMinutes(self::EXPIRATION_TIME);

        // Update verification data
        $verification->update([
            'token' => $token,
            'expires_at' => $expiresAt
        ]);

        // Reset timestamp in session for new countdown
        Session::put('verification_timestamp', time());

        // Send email
        try {
            Mail::to($request->email)->send(new VerificationCodeMail($token, $expiresAt, $verification->name));

            return redirect()->back()
                ->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengirim kode verifikasi: ' . $e->getMessage());
        }
    }
}
