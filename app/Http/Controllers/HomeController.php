<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Slide;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')
            ->where('sale_price', '<>', '')
            ->inRandomOrder()
            ->get()
            ->take(8);
        $fproducts = Product::where('featured', 1)->get()->take(8);
        $about      = About::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('index', compact('slides', 'categories', 'sproducts', 'fproducts', 'about',));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Handle empty query case
        if (empty($query)) {
            return response()->json([
                'results' => [],
                'count' => 0
            ]);
        }

        // Enhanced search query - works with single character searches 
        $results = Product::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('short_description', 'LIKE', "%{$query}%");
        })
            ->with('category') // Eager load category relationship if available
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get(['id', 'name', 'slug', 'image', 'regular_price']);

        return response()->json([
            'results' => $results,
            'count' => count($results)
        ]);
    }

    public function productSearch(Request $request)
    {
        $query = $request->input('search');

        $products = Product::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('short_description', 'LIKE', "%{$query}%");
        })
        ->with('category')
        ->paginate(12);

        // Redirect to your existing product listing page with search results
        return view('shop.product', [
            'products' => $products,
            'search_query' => $query,
            'title' => 'Search Results for: ' . $query
        ]);
    }

    public function produk()
    {
        return view('produk');
    }

    public function __construct()
    {
        // Semua method pada controller ini butuh login
        $this->middleware('auth')->only(['contact_store']);
    }

    public function contact()
    {
        return view('user.contact.index');
    }

    public function contact_store(Request $request)
    {

        // Flash input ke session agar old() tersedia :contentReference[oaicite:0]{index=0}
        $request->flash();

        // Jika belum login, redirect ke login sambil menandai form Kontak :contentReference[oaicite:1]{index=1}
        if (! $request->user()) {
            return redirect()->guest(route('login'))
                ->with('post_login_redirect', 'user.contact.index');
        }

        // Validasi
        $validated = $request->validate([
            'name'    => 'required|max:100',
            'email'   => 'required|email',
            'phone'   => 'required|numeric',
            'comment' => 'required',
        ]);

        // Buat instance model
        $contact = new Contact();
        $contact->name    = $validated['name'];
        $contact->email   = $validated['email'];
        $contact->phone   = $validated['phone'];
        $contact->comment = $validated['comment'];

        // Simpan sekali
        $contact->save(); // ← hanya satu INSERT

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim! Terima kasih telah menghubungi Bank Eceng Gondok. Tim kami akan memproses permintaan Anda dan segera menghubungi Anda melalui WhatsApp atau telepon.');
    }

    public function privacy_policy()
    {
        return view('privacy-policy');
    }

    public function terms_conditions()
    {
        return view('terms-conditions');
    }

    public function about()
    {
        // Ambil satu record About yang aktif
        $about = About::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->firstOrFail();

        return view('user.about.index', compact('about'));
    }
}
