<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WishlistController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;               // ← Tambahkan ini
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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

    protected function authenticated(Request $request, $user)
    {
        // Ambil dan hapus flag form dari session :contentReference[oaicite:5]{index=5}
        $form = $request->session()->pull('post_login_redirect');

        // Ambil old input di session store :contentReference[oaicite:6]{index=6}
        $old = session()->getOldInput();

        if ($form === 'contact') {
            // Re-flash input lama agar old() di form Kontak terisi :contentReference[oaicite:7]{index=7}
            session()->flashInput($old);
            return redirect()->route('home.contact');
        }

        if ($form === 'job-vacancy') {
            // Re-flash input lama agar old() di form Lowongan terisi :contentReference[oaicite:8]{index=8}
            session()->flashInput($old);
            return redirect()->route('job-vacancy');
        }

        // Jika ada query param redirect
        if ($request->has('redirect')) {
            $url = urldecode($request->query('redirect'));
            return redirect($url);
        }

        // Process any pending wishlist items
        $wishlistController = new WishlistController();
        $added = $wishlistController->processPendingWishlistItem();

        if ($added) {
            // Redirect to wishlist page with success message
            return redirect()->route('wishlist.index')
                ->with('success_message', 'You have successfully logged in and the product has been added to your wishlist.');
        }

        // Jika tidak ada flag, pakai intended URL atau fallback $redirectTo :contentReference[oaicite:9]{index=9}
        return redirect()->intended($this->redirectTo);
    }
}
