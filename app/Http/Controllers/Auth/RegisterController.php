<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
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
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+={}\[\]:;<>,.~\\\-]).{8,}$/'
            ],
            'privacy_policy' => ['required', 'accepted'],
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
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Format phone number with +62 prefix for storage
        $mobile = '62' . $data['mobile'];

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $mobile,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Override the registration method to use our custom verification flow
     */
    public function register(Request $request)
    {
        // Validate the request
        $this->validator($request->all())->validate();

        // Redirect to our custom verification flow
        return redirect()->route('verification.send', $request->all());
    }
}
