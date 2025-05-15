<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Slide;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index()
    {
        try {
            $slides = Slide::where('status', 1)->get()->take(3);
            $categories = Category::orderBy('name')->get();
            $sproducts = Product::whereNotNull('sale_price')
                ->where('sale_price', '<>', '')
                ->inRandomOrder()
                ->get()
                ->take(8);
            $fproducts = Product::where('featured', 1)->get()->take(8);

            return $this->sendResponse([
                'slides' => $slides,
                'categories' => $categories,
                'sale_products' => $sproducts,
                'featured_products' => $fproducts,
            ], 'Home data retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving home data', ['error' => $e->getMessage()], 500);
        }
    }

    public function contactStore(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:100',
                'email' => 'required|email',
                'phone' => 'required|numeric|digits:10',
                'comment' => 'required'
            ]);

            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->comment = $request->comment;
            $contact->save();

            return $this->sendResponse([], 'Your message has been sent successfully');
        } catch (\Exception $e) {
            return $this->sendError('Error sending your message', ['error' => $e->getMessage()], 500);
        }
    }
}
