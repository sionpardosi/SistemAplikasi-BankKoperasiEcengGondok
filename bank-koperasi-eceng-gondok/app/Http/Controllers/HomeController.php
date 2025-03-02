<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Slide;
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
        return view('index', compact('slides', 'categories'));
    }

    public function produk()
    {
        return view('produk');
    }
}
