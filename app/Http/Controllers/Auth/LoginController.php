<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WishlistController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm(Request $request)
    {
        if ($request->has('redirect')) {
            // Simpan URL tujuan ke intended
            \Illuminate\Support\Facades\Session::put('url.intended', $request->query('redirect'));
        }
        return view('auth.login');
    }

    // Override method untuk kostumisasi pesan error
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['Kredensial yang Anda masukkan tidak cocok dengan data kami.'],
        ]);
    }

    // Override method untuk validasi
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Alamat email harus diisi',
            'email.email' => 'Format alamat email tidak valid',
            'password.required' => 'Kata sandi harus diisi',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        // Ambil dan hapus flag form dari session
        $form = $request->session()->pull('post_login_redirect');

        // Ambil old input di session store
        $old = session()->getOldInput();

        if ($form === 'contact') {
            // Re-flash input lama agar old() di form Kontak terisi
            session()->flashInput($old);
            return redirect()->route('home.contact');
        }

        if ($form === 'job-vacancy') {
            // Re-flash input lama agar old() di form Lowongan terisi
            session()->flashInput($old);
            return redirect()->route('job-vacancy');
        }

        // Jika ada query param redirect
        if ($request->has('redirect')) {
            $url = urldecode($request->query('redirect'));
            return redirect($url);
        }

        if (Session::has('redirect_after_login')) {
            $redirect = Session::get('redirect_after_login');
            Session::forget('redirect_after_login');
            return redirect($redirect);
        }

        // Process any pending wishlist items
        $wishlistController = new WishlistController();
        $added = $wishlistController->processPendingWishlistItem();

        if ($added) {
            // Redirect to wishlist page with success message
            return redirect()->route('wishlist.index')
                ->with('success_message', 'You have successfully logged in and the product has been added to your wishlist.');
        }

        // Jika tidak ada flag, pakai intended URL atau fallback $redirectTo
        return redirect()->intended($this->redirectPath());
    }
}
