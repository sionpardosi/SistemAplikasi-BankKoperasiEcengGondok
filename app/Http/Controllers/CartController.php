<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    // ====================================================================================================
    // cart // --------------------------------- Cart Page  -----------------------------------------------
    // ====================================================================================================

    public function index()
    {
        // $cartItems = Cart::instance('cart')->content();
        $cartItems = Cart::instance('cart')->content();

        // return response()->json($cartItems);
        return view('cart', compact('cartItems'));
    }

    // ----------------- Add to Cart --------------------------------------------------------
    /**
     * Metode untuk menambahkan produk ke keranjang dengan dukungan ukuran
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->id);

        // Hitung stok yang tersedia = quantity - reserved_quantity
        $availableStock = $product->quantity - $product->reserved_quantity;

        // Ambil jumlah produk yang sudah ada di keranjang
        $cartItem = Cart::instance('cart')->content()->where('id', $request->id)->first();
        $currentCartQty = $cartItem ? $cartItem->qty : 0;

        $totalRequestedQty = $currentCartQty + $request->quantity;

        if ($totalRequestedQty > $availableStock) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total jumlah di keranjang melebihi stok yang tersedia (' . $availableStock . ').'
                ], 400);
            }
            return redirect()->back()->with('error', 'Total jumlah di keranjang melebihi stok yang tersedia.');
        }

        // Persiapkan options untuk menyimpan informasi ukuran jika ada
        $options = [];
        if ($request->has('size_id') && $request->size_id) {
            $size = Size::find($request->size_id);
            if ($size) {
                $options['size_id'] = $size->id;
                $options['size_name'] = $size->name;
            }
        }

        // Jika sudah ada di keranjang dengan ukuran yang sama, update qty
        if ($cartItem) {
            // Cek apakah item dengan ukuran yang sama sudah ada
            $existingItemWithSameSize = Cart::instance('cart')->content()->first(function ($item) use ($request) {
                return $item->id == $request->id &&
                    isset($item->options['size_id']) &&
                    $item->options['size_id'] == $request->size_id;
            });

            if ($existingItemWithSameSize) {
                // Update qty item yang sudah ada
                Cart::instance('cart')->update($existingItemWithSameSize->rowId, $existingItemWithSameSize->qty + $request->quantity);
            } else {
                // Tambahkan sebagai item baru dengan ukuran berbeda
                Cart::instance('cart')->add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => $request->quantity,
                    'price' => $product->sale_price ?: $product->regular_price,
                    'weight' => 0,
                    'options' => $options,
                ])->associate(Product::class);
            }
        } else {
            // Tambahkan item baru ke keranjang
            Cart::instance('cart')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->quantity,
                'price' => $product->sale_price ?: $product->regular_price,
                'weight' => 0,
                'options' => $options,
            ])->associate(Product::class);
        }

        // Jika user sudah login, simpan juga ke database
        if (Auth::check()) {
            $userId = Auth::id();

            // Simpan atau update item di database
            if (!empty($options)) {
                // Cek apakah item dengan produk dan ukuran yang sama sudah ada
                $dbCartItem = CartItem::where('user_id', $userId)
                    ->where('product_id', $product->id)
                    ->whereJsonContains('options->size_id', $options['size_id'])
                    ->first();

                if ($dbCartItem) {
                    // Update qty item yang sudah ada
                    $dbCartItem->quantity += $request->quantity;
                    $dbCartItem->save();
                } else {
                    // Buat item baru
                    CartItem::create([
                        'user_id' => $userId,
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $request->quantity,
                        'price' => $product->sale_price ?: $product->regular_price,
                        'options' => $options
                    ]);
                }
            } else {
                // Tanpa ukuran, cek item yang sudah ada berdasarkan produk saja
                $dbCartItem = CartItem::where('user_id', $userId)
                    ->where('product_id', $product->id)
                    ->whereNull('options')
                    ->first();

                if ($dbCartItem) {
                    $dbCartItem->quantity += $request->quantity;
                    $dbCartItem->save();
                } else {
                    CartItem::create([
                        'user_id' => $userId,
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $request->quantity,
                        'price' => $product->sale_price ?: $product->regular_price,
                        'options' => null
                    ]);
                }
            }
        }

        // Response
        $cartCount = Cart::instance('cart')->count();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'cartCount' => $cartCount]);
        }

        $checkoutRedirect = $request->input('checkout_redirect', 0);
        if ($checkoutRedirect == 1) {
            return redirect()->route('cart.index');
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // ----------------- Update Item Quantity Via AJAX -----------------------------------------------
    /**
     * Update quantity dengan validasi stok
     */
    public function update_item_quantity(Request $request, $rowId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil item dari cart
        $cartItem = Cart::instance('cart')->get($rowId);
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang'
            ], 404);
        }

        // Ambil data produk untuk cek stok
        $product = Product::find($cartItem->id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        // Hitung stok yang tersedia
        $availableStock = $product->quantity - $product->reserved_quantity;

        // Jika produk memiliki ukuran, cek stok berdasarkan ukuran
        if (isset($cartItem->options['size_id'])) {
            $sizeStock = DB::table('product_sizes')
                ->where('product_id', $product->id)
                ->where('size_id', $cartItem->options['size_id'])
                ->first();

            if ($sizeStock) {
                $availableStock = $sizeStock->stock;
            }
        }

        // Validasi quantity tidak melebihi stok
        if ($validated['quantity'] > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah yang diminta melebihi stok yang tersedia (' . $availableStock . ')',
                'available_stock' => $availableStock,
                'max_quantity' => $availableStock
            ], 400);
        }

        // Update quantity di cart
        Cart::instance('cart')->update($rowId, $validated['quantity']);

        // Update di database jika user login
        if (Auth::check()) {
            $dbCartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $cartItem->id);

            // Jika ada size_id, tambahkan kondisi
            if (isset($cartItem->options['size_id'])) {
                $dbCartItem->whereJsonContains('options->size_id', $cartItem->options['size_id']);
            } else {
                $dbCartItem->whereNull('options');
            }

            $dbCartItem = $dbCartItem->first();

            if ($dbCartItem) {
                $dbCartItem->quantity = $validated['quantity'];
                $dbCartItem->save();
            }
        }

        $updatedItem = Cart::instance('cart')->get($rowId);
        return response()->json([
            'success' => true,
            'quantity' => $updatedItem->qty,
            'subtotal' => $updatedItem->subtotal(0, '', ''),
            'available_stock' => $availableStock
        ]);
    }

    /**
     * GANTI METHOD increase_item_quantity YANG LAMA DENGAN INI
     */
    public function increase_item_quantity($rowId)
    {
        $cartItem = Cart::instance('cart')->get($rowId);
        if (!$cartItem) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
        }

        // Ambil data produk untuk cek stok
        $product = Product::find($cartItem->id);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        // Hitung stok yang tersedia
        $availableStock = $product->quantity - $product->reserved_quantity;

        // Jika produk memiliki ukuran, cek stok berdasarkan ukuran
        if (isset($cartItem->options['size_id'])) {
            $sizeStock = DB::table('product_sizes')
                ->where('product_id', $product->id)
                ->where('size_id', $cartItem->options['size_id'])
                ->first();

            if ($sizeStock) {
                $availableStock = $sizeStock->stock;
            }
        }

        $newQty = $cartItem->qty + 1;

        // Validasi quantity tidak melebihi stok
        if ($newQty > $availableStock) {
            return redirect()->back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia (' . $availableStock . ')');
        }

        Cart::instance('cart')->update($rowId, $newQty);
        return redirect()->back();
    }

    // ----------------- Reduce Item Quantity ----------------------------------------------
    public function reduce_item_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    // ----------------- Remove Item From Cart ---------------------------------------------
    public function remove_item_from_cart($rowId)
    {
        $item = Cart::instance('cart')->get($rowId);

        Cart::instance('cart')->remove($rowId);

        DB::table('user_cart_items')
            ->where('user_id', auth()->id())
            ->where('product_id', $item->id)
            ->delete();

        if (Cart::instance('cart')->count() == 0) {
            Cart::instance('cart')->destroy();
        }

        return redirect()->back();
    }

    // ----------------- Empty Cart --------------------------------------------------------
    public function empty_cart()
    {
        Cart::instance('cart')->destroy();

        DB::table('user_cart_items')
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->back();
    }


    // ====================================================================================================
    // COUPON // ------------------------ Apply Coupon Code -----------------------------------------------
    // ====================================================================================================

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            $coupon = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', Cart::instance('cart')->subtotal(0, '', ''))
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

    // ----------------- Cakculate Coupon Code -----------------------------------------------
    public function calculateDiscount()
    {
        // Pastikan subtotal yang diambil berupa angka polos (tanpa pemformatan)
        $cartSubtotal = floatval(Cart::instance('cart')->subtotal(0, '', ''));
        $discount = 0;
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            if ($coupon['type'] == 'fixed') {
                $discount = floatval($coupon['value']);
            } else {
                $discount = ($cartSubtotal * floatval($coupon['value'])) / 100;
            }
        }

        $subtotalAfterDiscount = $cartSubtotal - $discount;
        $taxRate = floatval(config('cart.tax'));
        $taxAfterDiscount = ($subtotalAfterDiscount * $taxRate) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        Session::put('discounts', [
            'discount' => number_format($discount, 2, '.', ''),
            'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
            'tax' => number_format($taxAfterDiscount, 2, '.', ''),
            'total' => number_format($totalAfterDiscount, 2, '.', '')
        ]);
    }

    // ----------------------------- Calculate Discount For Selected Items --------------------------------
    /**
     * Perubahan pada fungsi calculateDiscountForSelectedItems
     * untuk mengatasi item yang tidak ada di keranjang
     */
    public function calculateDiscountForSelectedItems($selectedItems)
    {
        $subtotal = 0;
        $validItems = [];

        // Hitung subtotal dari item yang dipilih dan masih ada di keranjang
        foreach ($selectedItems as $rowId) {
            try {
                $item = Cart::instance('cart')->get($rowId);
                if ($item) {
                    $subtotal += $item->subtotal(0, '', '');
                    $validItems[] = $rowId;
                }
            } catch (\Surfsidemedia\Shoppingcart\Exceptions\InvalidRowIDException $e) {
                // Item tidak ditemukan di keranjang, skip item ini
                continue;
            }
        }

        // Jika tidak ada item valid, kembalikan nilai default
        if (empty($validItems)) {
            return [
                'subtotal' => 0,
                'discount' => 0,
                'subtotalAfterDiscount' => 0,
                'tax' => 0,
                'total' => 0,
                'validItems' => $validItems
            ];
        }

        $discount = 0;
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            if ($coupon['type'] == 'fixed') {
                $discount = floatval($coupon['value']);
            } else {
                $discount = ($subtotal * floatval($coupon['value'])) / 100;
            }
        }

        $subtotalAfterDiscount = $subtotal - $discount;
        $taxRate = floatval(config('cart.tax'));
        $taxAfterDiscount = ($subtotalAfterDiscount * $taxRate) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'subtotalAfterDiscount' => $subtotalAfterDiscount,
            'tax' => $taxAfterDiscount,
            'total' => $totalAfterDiscount,
            'validItems' => $validItems
        ];
    }
    // Remove Coupon
    public function remove_coupon_code()
    {
        session()->forget('coupon');
        session()->forget('discounts');
        return back()->with('status', 'Coupon has been removed!');
    }


    // ====================================================================================================
    // CHECKOUT // ------------------------ Checkout Page -------------------------------------------------
    // ====================================================================================================

    /**
     * Perubahan pada fungsi checkout
     * untuk mengatasi item yang tidak ada di keranjang
     */
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route("login");
        }

        // Ambil item yang dipilih dari request
        $selectedItems = $request->has('selected_items') ? json_decode($request->selected_items, true) : [];

        // Proses item yang dipilih dan dapatkan hanya item valid yang masih ada di keranjang
        $validItems = $this->setAmountForCheckoutSelectedItems($selectedItems);

        // Jika tidak ada item valid, redirect ke keranjang dengan pesan error
        if (empty($validItems)) {
            return redirect()->route('cart.index')->with('error', 'Item yang dipilih tidak ditemukan di keranjang. Silakan pilih item lagi.');
        }

        // Simpan item yang valid di session untuk digunakan saat checkout
        session()->put('selected_cart_items', $validItems);

        // Ambil alamat default user
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', true)->first();

        // Jika tidak ada alamat default, ambil alamat pertama
        if (!$address) {
            $address = Address::where('user_id', Auth::user()->id)->first();
        }

        // Ambil semua alamat user untuk ditampilkan di dropdown
        $userAddresses = Address::where('user_id', Auth::user()->id)->get();

        // Hitung total berat dari item yang dipilih (asumsi 500g per item)
        $weight = 0;
        foreach ($validItems as $rowId) {
            try {
                $item = Cart::instance('cart')->get($rowId);
                if ($item) {
                    $weight += (500 * $item->qty); // 500g per item
                }
            } catch (\Exception $e) {
                // Skip jika item tidak ditemukan
                continue;
            }
        }

        // Jika tidak ada berat, gunakan berat default
        if ($weight <= 0) {
            $weight = 1000; // 1kg default
        }

        // Ambil data kurir yang tersedia
        $couriers = [
            'jne' => 'JNE',
            'pos' => 'POS Indonesia',
            'tiki' => 'TIKI'
        ];

        // Ambil rekening bank yang aktif
        $bankAccounts = BankAccount::where('is_active', true)->get();

        return view('checkout', compact('address', 'userAddresses', 'bankAccounts', 'couriers', 'weight'));
    }

    // ----------------- Set Amount For Checkout Selected Items ------------------------------------------
    /**
     * Perubahan pada fungsi setAmountForCheckoutSelectedItems
     * untuk mengatasi item yang tidak ada di keranjang
     */
    public function setAmountForCheckoutSelectedItems($selectedItems)
    {
        if (empty($selectedItems)) {
            session()->forget('checkout');
            return [];
        }

        $calculationResult = $this->calculateDiscountForSelectedItems($selectedItems);

        // Jika tidak ada item valid, hapus checkout dari session
        if (empty($calculationResult['validItems'])) {
            session()->forget('checkout');
            return [];
        }

        // Simpan hasil perhitungan ke session
        session()->put('checkout', [
            'discount' => $calculationResult['discount'],
            'subtotal' => $calculationResult['subtotal'],
            'tax' => $calculationResult['tax'],
            'total' => $calculationResult['total']
        ]);

        // Kembalikan array item yang valid untuk diproses
        return $calculationResult['validItems'];
    }



    // ====================================================================================================
    // SET AMOUNT FOR CHECKOUT // ------------------------ Set Amount For Checkout ------------------------
    // ====================================================================================================
    public function setAmountForCheckout()
    {
        if (!Cart::instance('cart')->count() > 0) {
            session()->forget('checkout');
            return;
        }

        if (session()->has('coupon')) {
            session()->put('checkout', [
                'discount' => (float) session()->get('discounts')['discount'],
                'subtotal' => (float) session()->get('discounts')['subtotal'],
                'tax' => (float) session()->get('discounts')['tax'],
                'total' => (float) session()->get('discounts')['total']
            ]);
        } else {
            session()->put('checkout', [
                'discount' => 0,
                'subtotal' => (float) Cart::instance('cart')->subtotal(0, '', ''),
                'tax' => (float) Cart::instance('cart')->tax(0, '', ''),
                'total' => (float) Cart::instance('cart')->total(0, '', '')
            ]);
        }
    }


    // ====================================================================================================
    // PLACE ORDER // ------------------------ Place Order -----------------------------------------------
    // ====================================================================================================
    /**
     * Perbaikan pada metode place_order di CartController.php
     */
    public function place_order(Request $request)
    {
        $user_id = Auth::user()->id;

        // Jika menggunakan alamat yang sudah ada
        if ($request->has('address_id') && $request->address_id > 0) {
            $address = Address::where('id', $request->address_id)
                ->where('user_id', $user_id)
                ->firstOrFail();
        }
        // Jika membuat alamat baru
        else {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric',
                'zip' => 'required',
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
            $address->idcity = $request->idcity;
            $address->idstate = $request->idstate;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = $request->country ?? 'Indonesia';

            // Set sebagai alamat default jika diminta atau tidak ada alamat lain
            if ($request->has('save_address') && $request->save_address) {
                // Jika ini alamat pertama atau user meminta set sebagai default
                $isFirstAddress = !Address::where('user_id', $user_id)->exists();
                if ($isFirstAddress || $request->has('isdefault')) {
                    // Set semua alamat user menjadi non-default
                    Address::where('user_id', $user_id)->update(['isdefault' => false]);
                    $address->isdefault = true;
                }

                $address->save();
            }
        }

        // Ambil item yang dipilih dari session (diset sebelumnya di checkout)
        $selectedItems = session()->get('selected_cart_items', []);

        // Jika tidak ada item yang dipilih, redirect kembali ke cart
        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih untuk checkout');
        }

        // Gunakan rincian pembayaran yang sudah dihitung sebelumnya
        if (!session()->has('checkout')) {
            $validItems = $this->setAmountForCheckoutSelectedItems($selectedItems);
            if (empty($validItems)) {
                return redirect()->route('cart.index')->with('error', 'Item yang dipilih tidak ditemukan di keranjang. Silakan pilih item lagi.');
            }
        }

        // Proses order
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'] + $request->ongkir;
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->ongkir = $request->ongkir;
        $order->kurir = $request->kurir;
        $order->status = 'awaiting_payment'; // Status baru yang lebih spesifik
        $order->save();

        // Simpan hanya item yang dipilih sebagai order item
        $validItems = [];
        foreach ($selectedItems as $rowId) {
            try {
                $item = Cart::instance('cart')->get($rowId);
                if ($item) {
                    $orderitem = new OrderItem();
                    $orderitem->product_id = $item->id;
                    $orderitem->order_id = $order->id;
                    $orderitem->price = $item->price;
                    $orderitem->quantity = $item->qty;
                    $orderitem->options = $item->options;
                    $orderitem->save();

                    // Hapus item dari keranjang setelah ditambahkan ke order
                    Cart::instance('cart')->remove($rowId);

                    // Hapus juga dari database jika user login
                    if (Auth::check()) {
                        CartItem::where('user_id', $user_id)
                            ->where('product_id', $item->id)
                            ->delete();
                    }

                    $validItems[] = $rowId;
                }
            } catch (\Exception $e) {
                // Skip item yang tidak ditemukan
                continue;
            }
        }

        // Jika tidak ada item valid yang bisa diproses, batalkan order
        if (empty($validItems)) {
            $order->delete();
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang valid untuk diproses');
        }

        // Gunakan invoice sebagai order_id yang tetap
        $invoice = 'ORDER-' . $order->id . '-' . Str::uuid();

        // Midtrans Configuration hanya jika metode pembayaran adalah card
        $snapToken = null;
        if ($request->mode == 'card') {
            // Midtrans Configuration
            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $invoice,
                    'gross_amount' => (int) $order->total,
                ],
                'customer_details' => [
                    'first_name' => $order->name,
                    'phone' => $order->phone,
                ]
            ];

            try {
                // Ambil snap token dari Midtrans
                $snapToken = Snap::getSnapToken($params);
            } catch (\Exception $e) {
                Log::error('Midtrans Snap Error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat proses pembayaran: ' . $e->getMessage());
            }
        }


        // Simpan transaksi dengan status 'pending'
        $transaction = [
            'user_id' => $user_id,
            'order_id' => $order->id,
            'invoice' => $invoice,
            'mode' => $request->mode,
            'status' => 'pending', // Pastikan status awal transaksi adalah pending
            'snap_token' => $snapToken,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Tambahkan bank_code untuk metode manual_atm
        if ($request->mode == 'manual_atm') {
            $transaction['bank_code'] = 'BNI'; // Set default ke BNI sesuai requirement
            // Hapus baris ini: $transaction['payment_proof'] = $paymentProofPath;
        }

        DB::table('transactions')->insert($transaction);

        // Tambahkan notifikasi
        DB::table('notifications')->insert([
            'pesan' => 'Pesanan Baru Dari ' . $order->name . ' dengan Invoice ' . $invoice . ' dengan status pending',
            'waktu' => now(),
            'status' => 'unread',
        ]);

        DB::beginTransaction();
        try {
            // Update reserved_quantity untuk setiap produk sesuai qty di order items
            foreach ($validItems as $rowId) {
                try {
                    $item = Cart::instance('cart')->get($rowId);
                    if ($item) {
                        $product = Product::lockForUpdate()->find($item->id); // Lock row untuk concurrency
                        $availableStock = $product->quantity - $product->reserved_quantity;

                        if ($item->qty > $availableStock) {
                            DB::rollBack();
                            return redirect()->back()->with('error', "Stok produk {$product->name} tidak cukup.");
                        }

                        // Tambah reserved_quantity
                        $product->reserved_quantity += $item->qty;
                        $product->save();
                    }
                } catch (\Exception $e) {
                    // Skip item yang tidak ditemukan
                    continue;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error place_order stok: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }

        // Jika masih ada item di keranjang, tidak perlu destroy seluruh keranjang
        if (Cart::instance('cart')->count() === 0) {
            Cart::instance('cart')->destroy();
        }

        session()->forget('selected_cart_items');
        session()->forget('checkout');
        session()->put('order_id', $order->id);

        return redirect()->route('cart.confirmation');
    }


    // ====================================================================================================
    // CONFIRMATION // ------------------------ Order Confirmation -------------------------------------
    // ====================================================================================================
    public function confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            $snaptoken = DB::table('transactions')->where('order_id', $order->id)->first()->snap_token;
            return view('order-confirmation', compact('order', 'snaptoken'));
        }
        return redirect()->route('cart.index');
    }

    /**
     * Upload bukti pembayaran untuk transfer bank
     */
    public function uploadPaymentProof(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        // Upload file
        $file = $request->file('payment_proof');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $paymentProofPath = $file->storeAs('payment_proofs', $fileName, 'public');

        // Update transaction dengan bukti pembayaran
        $transaction = Transaction::where('order_id', $order->id)->first();
        if ($transaction) {
            $transaction->payment_proof = $paymentProofPath;
            $transaction->save();

            // Update status order jika diperlukan
            $order->status = 'pending'; // Ubah status menjadi pending menunggu verifikasi admin
            $order->save();

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Pesanan Anda akan segera diverifikasi.');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran.');
    }
}
