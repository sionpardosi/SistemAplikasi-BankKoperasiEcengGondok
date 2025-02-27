<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    // Cart Page
    public function index()
    {
        // $cartItems = Cart::instance('cart')->content();
        $cartItems = Cart::instance('cart')->content();
        return view('cart', compact('cartItems'));
    }
    // Add to Cart
    public function addToCart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        // session()->flash('success', 'Product is Added to Cart Successfully !');
        // return response()->json(['status' => 200, 'message' => 'Success ! Item Successfully added to your cart.']);
        return redirect()->back();
    }
    // Increase Item Quantity
    public function increase_item_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }
    // Reduce Item Quantity
    public function reduce_item_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }
    // Remove Item from Cart
    public function remove_item_from_cart($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }
    // Empty Cart
    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    // // Calculate Discounts
    // public function apply_coupon_code(Request $request)
    // {
    //     $coupon_code = $request->coupon_code;
    //     if(isset($coupon_code))
    //     {
    //         $coupon = Coupon::where('code',$coupon_code)->where('expiry_date','>=',Carbon::today())->where('cart_value','<=',Cart::instance('cart')->subtotal())->first();
    //         if(!$coupon)
    //         {
    //             return back()->with('error','Invalid coupon code!');
    //         }
    //         session()->put('coupon',[
    //             'code' => $coupon->code,
    //             'type' => $coupon->type,
    //             'value' => $coupon->value,
    //             'cart_value' => $coupon->cart_value
    //         ]);
    //         $this->calculateDiscounts();
    //         return back()->with('status','Coupon code has been applied!');
    //     }
    //     else{
    //         return back()->with('error','Invalid coupon code!');
    //     }
    // }
    // public function calculateDiscounts()
    // {
    //     $discount = 0;
    //     if(session()->has('coupon'))
    //     {
    //         if(session()->get('coupon')['type'] == 'fixed')
    //         {
    //             $discount = session()->get('coupon')['value'];
    //         }
    //         else
    //         {
    //             $discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
    //         }

    //         $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
    //         $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax'))/100;


    //         $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

    //         session()->put('discounts',[
    //             'discount' => number_format(floatval($discount),2,'.',''),
    //             'subtotal' => number_format(floatval(Cart::instance('cart')->subtotal() - $discount),2,'.',''),
    //             'tax' => number_format(floatval((($subtotalAfterDiscount * config('cart.tax'))/100)),2,'.',''),
    //             'total' => number_format(floatval($subtotalAfterDiscount + $taxAfterDiscount),2,'.','')
    //         ]);
    //     }
    // }
    // public function removeCoupon()
    // {
    //     Session::forget('coupon');
    //     Session::forget('discounts');
    //     return back()->with('status', 'Coupon berhasil dihapus.');
    // }
    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            $coupon = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', Cart::instance('cart')->subtotal())
                ->first();

            if (!$coupon) {
                return redirect()->back()->with('error', 'Invalid coupon code!');
            } else {
                Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ]);
                $this->calculateDiscount();
                return redirect()->back()->with('success', 'Coupon has been applied!');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid coupon code!');
        }
    }

    public function calculateDiscount()
    {
        $discount = 0;
        if (Session::has('coupon')) {
            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            } else {
                $discount = (Cart::instance('cart')->subtotal() * Session::get('coupon')['value']) / 100;
            }
        }

        $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
        $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        Session::put('discounts', [
            'discount' => number_format(floatval($discount), 2, '.', ''),
            'subtotal' => number_format(floatval(Cart::instance('cart')->subtotal() - $discount), 2, '.', ''),
            'tax' => number_format(floatval((($subtotalAfterDiscount * config('cart.tax')) / 100)), 2, '.', ''),
            'total' => number_format(floatval($subtotalAfterDiscount + $taxAfterDiscount), 2, '.', '')
        ]);
    }

    public function remove_coupon_code()
    {
        session()->forget('coupon');
        session()->forget('discounts');
        return back()->with('status', 'Coupon has been removed!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route("login");
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact("address"));
    }

    public function place_order(Request $request)
    {
        $user_id = Auth::user()->id;

        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();
        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required'
            ]);

            $address = new Address();
            $address->user_id = $user_id;
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = '';
            $address->isdefault = true;
            $address->save();
        }

        $this->setAmountForCheckout();

        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            $orderitem = new OrderItem();
            $orderitem->product_id = $item->id;
            $orderitem->order_id = $order->id;
            $orderitem->price = $item->price;
            $orderitem->quantity = $item->qty;
            $orderitem->save();
        }

        if ($request->mode == 'card') {
        } elseif ($request->mode == 'paypal') {
        } elseif ($request->mode == 'cod') {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = "pending";
            $transaction->save();
        }

        Cart::instance('cart')->destroy();
        session()->forget('checkout');
        session()->forget('coupon');
        session()->forget('discounts');
        session()->put('order_id', $order->id);
        return redirect()->route('cart.confirmation');
    }

    public function setAmountForCheckout()
    {
        if (!Cart::instance('cart')->count() > 0) {
            session()->forget('checkout');
            return;
        }

        if (session()->has('coupon')) {
            session()->put('checkout', [
                'discount' => session()->get('discounts')['discount'],
                'subtotal' =>  session()->get('discounts')['subtotal'],
                'tax' =>  session()->get('discounts')['tax'],
                'total' =>  session()->get('discounts')['total']
            ]);
        } else {
            session()->put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total()
            ]);
        }
    }

    public function confirmation()
    {
        if(Session::has('order_id'))
        {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
