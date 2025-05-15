<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Mail\VerificationCodeMail;
use App\Models\EmailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends BaseController
{
    // Waktu kedaluwarsa untuk kode verifikasi (dalam menit)
    const EXPIRATION_TIME = 10;

    /**
     * Mengirimkan kode verifikasi ke email
     */
    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|unique:users|min:10|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
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

        // Send email
        try {
            Mail::to($request->email)->send(new VerificationCodeMail($token, $expiresAt, $request->name));

            return $this->sendResponse([
                'email' => $request->email,
                'expires_at' => $expiresAt->format('Y-m-d H:i:s')
            ], 'Kode verifikasi telah dikirim ke email Anda.');

        } catch (\Exception $e) {
            return $this->sendError('Failed to send verification code', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Verifikasi kode yang dimasukkan user
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'verification_code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $verification = EmailVerification::where('email', $request->email)
            ->where('token', $request->verification_code)
            ->first();

        if (!$verification) {
            return $this->sendError('Invalid verification code', ['error' => 'Kode verifikasi tidak valid.'], 400);
        }

        if ($verification->isExpired()) {
            return $this->sendError('Expired verification code', ['error' => 'Kode verifikasi sudah kedaluwarsa. Silakan minta kode baru.'], 400);
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

        // Generate token for authenticated access
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse([
            'user' => $user,
            'token' => $token
        ], 'Pendaftaran berhasil! Akun Anda telah diverifikasi.');
    }

    /**
     * Kirim ulang kode verifikasi
     */
    public function resendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $verification = EmailVerification::where('email', $request->email)->first();

        if (!$verification) {
            return $this->sendError('Registration data not found', ['error' => 'Data pendaftaran tidak ditemukan.'], 404);
        }

        // Generate new verification code
        $token = EmailVerification::generateToken();
        $expiresAt = Carbon::now()->addMinutes(self::EXPIRATION_TIME);

        // Update verification data
        $verification->update([
            'token' => $token,
            'expires_at' => $expiresAt
        ]);

        // Send email
        try {
            Mail::to($request->email)->send(new VerificationCodeMail($token, $expiresAt, $verification->name));

            return $this->sendResponse([
                'email' => $request->email,
                'expires_at' => $expiresAt->format('Y-m-d H:i:s')
            ], 'Kode verifikasi baru telah dikirim ke email Anda.');

        } catch (\Exception $e) {
            return $this->sendError('Failed to send verification code', ['error' => $e->getMessage()], 500);
        }
    }
}
