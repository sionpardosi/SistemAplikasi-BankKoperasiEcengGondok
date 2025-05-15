<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class AuthController extends BaseController
{
    // 🔹 REGISTER (Pendaftaran Akun Baru)
    public function register(Request $request)
    {
        // Validasi input dari form
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => [
                'required',
                'string',
                'unique:users',
                'regex:/^8[1-9][0-9]{6,12}$/', // Format Indonesian phone number (starts with 8)
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/' // At least one lowercase, one uppercase, one number
            ],
            'privacy_policy' => 'required|accepted',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah digunakan.',
            'mobile.required' => 'Nomor telepon wajib diisi.',
            'mobile.regex' => 'Format nomor telepon tidak valid. Gunakan format 8xxxxxxxxxx (tanpa awalan 0).',
            'mobile.unique' => 'Nomor telepon sudah digunakan.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf kecil, huruf besar, dan angka.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'privacy_policy.required' => 'Anda harus menyetujui kebijakan privasi kami.',
            'privacy_policy.accepted' => 'Anda harus menyetujui kebijakan privasi kami.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        // Format phone number with +62 prefix for storage
        $mobile = '62' . $request->mobile;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $mobile,
            'password' => Hash::make($request->password),
        ]);

        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();

        return $this->sendResponse($user, 'User registered successfully. Please check your email for verification.');
    }

    // 🔹 LOGIN
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);


            if (!Auth::attempt($credentials)) {
                return $this->sendError('Unauthorized', ['error' => 'Invalid credentials'], 401);
            }

            $user_login = Auth::user();
            $user = User::find($user_login->id);

            // Jika ada cart_data di database, load kembali ke session cart
            if ($user->cart_data) {
                $cartItems = json_decode($user->cart_data, true);
                foreach ($cartItems as $item) {
                    Cart::instance('cart')->add(
                        $item['id'],
                        $item['name'],
                        $item['qty'],
                        $item['price']
                    )->associate(Product::class);
                }
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->sendResponse([
                'token' => $token,
                'user' => $user,
                'cart' => Cart::instance('cart')->content()
            ], 'Login successful.');
        } catch (\Exception $e) {
            return $this->sendError('An error occurred', ['error' => $e->getMessage()], 500);
        }
    }

    // 🔹 KONFIRMASI PASSWORD
    public function confirmPassword(Request $request)
    {
        // $request->validate([
        //     'password' => 'required|string',
        // ]);

        $user = Auth::guard('sanctum')->user();
        // if (!Hash::check($request->password, $user->password)) {
        //     return $this->sendError('Invalid password', ['error' => 'Password confirmation failed.'], 403);
        // }

        return $this->sendResponse(['user' => $user], 'Password confirmed successfully.');
    }

    // 🔹 LUPA PASSWORD (Mengirimkan Email Reset Password)
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? $this->sendResponse([], 'Reset password email sent successfully.')
            : $this->sendError('Failed to send reset email', ['error' => __($status)], 500);
    }

    // 🔹 RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                $user->tokens()->delete(); // Logout dari semua sesi
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->sendResponse([], 'Password reset successfully.')
            : $this->sendError('Failed to reset password', ['error' => __($status)], 500);
    }

    // 🔹 VERIFIKASI EMAIL
    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return $this->sendError('Invalid verification link', [], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return $this->sendResponse([], 'Email already verified.');
        }

        $user->markEmailAsVerified();
        return $this->sendResponse([], 'Email successfully verified.');
    }

    // 🔹 KIRIM ULANG VERIFIKASI EMAIL
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendError('Email already verified.', [], 400);
        }

        $request->user()->sendEmailVerificationNotification();
        return $this->sendResponse([], 'Verification email resent successfully.');
    }

    // 🔹 LOGOUT
    public function logout(Request $request)
    {
        $user_login = Auth::guard('sanctum')->user();
        $user = User::find($user_login->id);

        // $request->user()->currentAccessToken()->delete();
        $user->tokens()->delete();
        Cart::instance('cart')->destroy(); // Hapus session cart

        return $this->sendResponse([], 'Logged out successfully.');
    }
}
