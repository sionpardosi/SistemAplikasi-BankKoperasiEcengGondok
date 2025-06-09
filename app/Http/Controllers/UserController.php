<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\PendingOrder;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\SupplierRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view("user.index");
    }

    public function job()
    {
        try {
            $applications = JobApplication::with('job')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();

            return view('user.job_vacancy.index', compact('applications'));
        } catch (\Exception $e) {
            // Jika terjadi error, kirim array kosong untuk applications
            $applications = collect();
            return view('user.job_vacancy.index', compact('applications'));
        }
    }

    public function account_orders()
    {
        // Ambil order yang sudah confirmed/dibayar
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(8);

        // Ambil pending orders yang belum expired
        $pendingOrders = PendingOrder::where('user_id', Auth::user()->id)
            ->where('status', 'pending_payment')
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('user.orders', compact('orders', 'pendingOrders'));
    }

    public function account_order_details($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->find($order_id);

        if (!$order) {
            return redirect()->route('user.account.orders')->with('error', 'Pesanan tidak ditemukan');
        }

        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();

        return view('user.order-details', compact('order', 'orderItems', 'transaction'));
    }

    /**
     * ✅ DIPERBAIKI: Cancel order dengan release reserved stock
     */
    public function account_cancel_order(Request $request)
    {
        $order = Order::where('user_id', Auth::user()->id)->find($request->order_id);

        if (!$order) {
            return back()->with("error", "Order tidak ditemukan!");
        }

        // Cek apakah order bisa dibatalkan
        if (!in_array($order->status, ['awaiting_payment', 'pending', 'confirmed'])) {
            return back()->with("error", "Order tidak dapat dibatalkan pada status ini!");
        }

        DB::beginTransaction();
        try {
            // Update status order
            $order->status = "canceled";
            $order->canceled_date = Carbon::now();
            $order->save();

            // Update status transaksi jika ada
            $transaction = Transaction::where('order_id', $order->id)->first();
            if ($transaction) {
                $transaction->status = 'declined';
                $transaction->save();
            }

            // ✅ PERBAIKAN: Release reserved stock
            $this->releaseReservedStock($order);

            DB::commit();

            return back()->with("status", "Order berhasil dibatalkan dan stok dikembalikan!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error canceling order: ' . $e->getMessage());
            return back()->with("error", "Gagal membatalkan pesanan. Silakan coba lagi.");
        }
    }

    // Menambahkan method baru untuk konfirmasi penerimaan pesanan
    public function account_confirm_delivery(Request $request)
    {
        // Validasi request
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        // Mengambil data order
        $order = Order::where('user_id', Auth::user()->id)->find($request->order_id);

        // Memeriksa apakah order ditemukan dan statusnya adalah 'delivered'
        if (!$order || $order->status !== 'delivered') {
            return back()->with('error', 'Tidak dapat mengonfirmasi penerimaan. Status pesanan harus "Diterima Admin".');
        }

        // Update status menjadi completed
        $order->status = 'completed';
        $order->completed_date = Carbon::now();
        $order->save();

        return back()->with('status', 'Pesanan berhasil dikonfirmasi telah diterima. Terima kasih!');
    }

    /**
     * ✅ DIPERBAIKI: Auto check payment status via AJAX (memanggil Midtrans API)
     */
    public function autoCheckPaymentStatus(Request $request)
    {
        $transaction = Transaction::where('id', $request->transaction_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // ✅ PERBAIKAN: Cek dulu apakah sudah dibayar di database
        if (in_array($transaction->status, ['approved', 'paid'])) {
            return response()->json([
                'status' => 'approved',
                'message' => 'Payment already confirmed',
                'already_paid' => true
            ]);
        }

        // Cek apakah snap token masih valid
        if (!$transaction->snap_token || $transaction->isSnapTokenExpired()) {
            return response()->json([
                'status' => $transaction->status,
                'error' => 'Snap token expired or invalid',
                'token_expired' => true
            ]);
        }

        try {
            // Cek status di Midtrans API langsung
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');

            $status = \Midtrans\Transaction::status($transaction->invoice);

            \Illuminate\Support\Facades\Log::info('Auto check - Midtrans status: ' . $status->transaction_status);

            // ✅ PERBAIKAN: Update status berdasarkan response dari Midtrans DAN kurangi stok
            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                DB::beginTransaction();
                try {
                    $transaction->status = 'approved';
                    $transaction->save();

                    if ($transaction->order) {
                        $transaction->order->status = 'confirmed';
                        $transaction->order->confirmed_date = now();
                        $transaction->order->save();

                        // ✅ PERBAIKAN: Kurangi stok produk
                        $this->reduceProductStock($transaction->order);
                    }

                    DB::commit();

                    return response()->json([
                        'status' => 'approved',
                        'message' => 'Payment confirmed and stock updated'
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error updating payment status: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                return response()->json([
                    'status' => $transaction->status,
                    'midtrans_status' => $status->transaction_status,
                    'message' => 'Payment still pending'
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error auto checking payment status: ' . $e->getMessage());
            return response()->json([
                'status' => $transaction->status,
                'error' => 'Failed to check payment status'
            ]);
        }
    }

    /**
     * ✅ DIPERBAIKI: Manual refresh status transaksi (untuk debugging)
     */
    public function manualRefreshStatus(Request $request)
    {
        $transaction = Transaction::where('id', $request->transaction_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        // Log current status
        \Illuminate\Support\Facades\Log::info('Manual refresh - Current status: ' . $transaction->status);

        // Cek di Midtrans API langsung
        try {
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');

            $status = \Midtrans\Transaction::status($transaction->invoice);

            \Illuminate\Support\Facades\Log::info('Midtrans API Response: ', (array) $status);

            // ✅ PERBAIKAN: Update status berdasarkan response dari Midtrans DAN kurangi stok
            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                DB::beginTransaction();
                try {
                    $transaction->status = 'approved';
                    $transaction->save();

                    if ($transaction->order) {
                        $transaction->order->status = 'confirmed';
                        $transaction->order->confirmed_date = now();
                        $transaction->order->save();

                        // ✅ PERBAIKAN: Kurangi stok produk
                        $this->reduceProductStock($transaction->order);
                    }

                    DB::commit();

                    return redirect()->back()->with('success', 'Status berhasil diperbarui menjadi PAID dan stok dikurangi');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error updating manual refresh: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('info', 'Status Midtrans: ' . $status->transaction_status);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error checking Midtrans status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * ✅ METHOD BARU: Kurangi stok produk ketika pembayaran berhasil
     */
    private function reduceProductStock(Order $order)
    {
        foreach ($order->orderItems as $orderItem) {
            $product = Product::lockForUpdate()->find($orderItem->product_id);

            if ($product) {
                Log::info("UserController - Processing stock reduction for product {$product->id}, quantity: {$orderItem->quantity}");

                // Parse options untuk mendapatkan size_id jika ada
                $options = [];
                if ($orderItem->options) {
                    if (is_string($orderItem->options)) {
                        $options = json_decode($orderItem->options, true) ?? [];
                    } else {
                        $options = $orderItem->options;
                    }
                }

                // ✅ PERBAIKAN: Cek apakah produk memiliki ukuran berdasarkan relasi sizes
                $hasSize = $product->sizes()->count() > 0;

                if ($hasSize && isset($options['size_id'])) {
                    // Untuk produk dengan ukuran
                    $sizeId = $options['size_id'];

                    Log::info("UserController - Product {$product->id} has sizes, reducing size {$sizeId} stock");

                    // Update stok di tabel product_size
                    $productSize = DB::table('product_size')
                        ->where('product_id', $product->id)
                        ->where('size_id', $sizeId)
                        ->first();

                    if ($productSize && $productSize->stock >= $orderItem->quantity) {
                        DB::table('product_size')
                            ->where('product_id', $product->id)
                            ->where('size_id', $sizeId)
                            ->decrement('stock', $orderItem->quantity);

                        Log::info("✅ UserController - Size stock reduced for product {$product->id} size {$sizeId} by {$orderItem->quantity}");
                    } else {
                        Log::warning("❌ UserController - Insufficient size stock for product {$product->id} size {$sizeId}");
                    }
                } else {
                    // ✅ PERBAIKAN: Untuk produk TANPA ukuran, pastikan stok utama berkurang
                    Log::info("UserController - Product {$product->id} has NO sizes, reducing main stock");
                }

                // ✅ PERBAIKAN: SELALU kurangi stok utama dan reserved quantity
                // Baik untuk produk dengan ukuran maupun tanpa ukuran
                if ($product->quantity >= $orderItem->quantity && $product->reserved_quantity >= $orderItem->quantity) {
                    $oldQuantity = $product->quantity;
                    $oldReserved = $product->reserved_quantity;

                    $product->quantity -= $orderItem->quantity;
                    $product->reserved_quantity -= $orderItem->quantity;

                    // Pastikan reserved_quantity tidak negatif
                    if ($product->reserved_quantity < 0) {
                        $product->reserved_quantity = 0;
                    }

                    $product->save();

                    Log::info("✅ UserController - Product {$product->id} main stock reduced: {$oldQuantity} -> {$product->quantity}, reserved: {$oldReserved} -> {$product->reserved_quantity}");
                } else {
                    Log::warning("❌ UserController - Insufficient main stock for product {$product->id}. Available: {$product->quantity}, Reserved: {$product->reserved_quantity}, Needed: {$orderItem->quantity}");
                }
            } else {
                Log::error("❌ UserController - Product {$orderItem->product_id} not found");
            }
        }
    }
    /**
     * ✅ METHOD BARU: Release reserved stock ketika pembayaran gagal/dibatalkan
     */
    private function releaseReservedStock(Order $order)
    {
        foreach ($order->orderItems as $orderItem) {
            $product = Product::lockForUpdate()->find($orderItem->product_id);

            if ($product && $product->reserved_quantity >= $orderItem->quantity) {
                $product->reserved_quantity -= $orderItem->quantity;

                // Pastikan reserved_quantity tidak negatif
                if ($product->reserved_quantity < 0) {
                    $product->reserved_quantity = 0;
                }

                $product->save();

                Log::info("Reserved stock released for product {$product->id} by {$orderItem->quantity}");
            }
        }
    }

    /**
     * Check payment status untuk AJAX request
     */
    public function checkPaymentStatus($transaction_id)
    {
        $transaction = Transaction::where('id', $transaction_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json([
            'status' => $transaction->status,
            'order_status' => $transaction->order ? $transaction->order->status : null
        ]);
    }

    // Halaman untuk menampilkan detail transaksi pembayaran
    public function order_payment($transaction_id)
    {
        $transaction = Transaction::where('id', $transaction_id)->first();
        $order = Order::find($transaction->order_id);
        $snaptoken = $transaction->snap_token;

        return view('order-payment', compact('transaction', 'order', 'snaptoken'));
    }

    // Load juga relasi 'penjadwalan'
    public function supplier_request()
    {
        $requests = SupplierRequest::where('user_id', Auth::user()->id)->latest()->get();
        $requests = SupplierRequest::with('penjadwalan')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(3);      // ← berubah di sini

        return view('user.supplier.details', compact('requests'));
    }

    // Halaman alamat user - menampilkan semua alamat pengguna
    public function accountAddress()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('user.address.account-address', compact('addresses'));
    }

    // Halaman tambah alamat user
    public function addAddress()
    {
        return view('user.address.add-address');
    }

    // Menyimpan alamat baru
    public function storeAddress(Request $request)
    {
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
        $address->user_id = Auth::id();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->country = $request->country ?? 'Indonesia';
        $address->type = $request->type ?? 'home';

        // Jika ini adalah alamat pertama atau user meminta set sebagai default
        $isFirstAddress = !Address::where('user_id', Auth::id())->exists();
        if ($isFirstAddress || $request->isdefault) {
            // Set semua alamat user menjadi non-default
            Address::where('user_id', Auth::id())->update(['isdefault' => false]);
            $address->isdefault = true;
        }

        $address->save();

        return redirect()->route('user.address.account-address')
            ->with('success', 'Alamat berhasil ditambahkan');
    }

    // Halaman edit alamat
    public function editAddress($id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.address.edit-address', compact('address'));
    }

    // Update alamat
    public function updateAddress(Request $request, $id)
    {
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

        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->country = $request->country ?? $address->country;
        $address->type = $request->type ?? $address->type;

        // Jika user meminta set sebagai default
        if ($request->isdefault) {
            // Set semua alamat user menjadi non-default
            Address::where('user_id', Auth::id())->update(['isdefault' => false]);
            $address->isdefault = true;
        }

        $address->save();

        return redirect()->route('user.address.account-address')
            ->with('success', 'Alamat berhasil diperbarui');
    }

    // Hapus alamat
    public function deleteAddress($id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $isDefault = $address->isdefault;

        $address->delete();

        // Jika alamat yang dihapus adalah default, set alamat lain sebagai default jika ada
        if ($isDefault) {
            $newDefault = Address::where('user_id', Auth::id())->first();
            if ($newDefault) {
                $newDefault->isdefault = true;
                $newDefault->save();
            }
        }

        return redirect()->route('user.address.account-address')
            ->with('success', 'Alamat berhasil dihapus');
    }

    // Set alamat sebagai default
    public function setDefaultAddress($id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Set semua alamat user menjadi non-default
        Address::where('user_id', Auth::id())->update(['isdefault' => false]);

        // Set alamat ini sebagai default
        $address->isdefault = true;
        $address->save();

        return redirect()->route('user.address.account-address')
            ->with('success', 'Alamat berhasil diatur sebagai default');
    }


    public function accountDetails()
    {
        $user = Auth::user();
        return view("user.accountdetails.account-details", compact('user'));
    }


    public function account_pending_order_details($pending_order_id)
    {
        $pendingOrder = PendingOrder::with(['items.product', 'transaction'])
            ->where('user_id', Auth::user()->id)
            ->findOrFail($pending_order_id);

        return view('user.pending-order-details', compact('pendingOrder'));
    }


    // Memperbarui detail akun pengguna
    public function updateAccountDetails(Request $request)
    {
        $user = Auth::user();

        // Validasi input dasar (nama, email, nomor HP, dan bio)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => [
                'required',
                'string',
                'min:10',
                'max:15',
                'unique:users,mobile,' . $user->id,
                'regex:/^(08|628)[0-9]{8,12}$/' // Format Indonesia
            ],
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto profil
            'profile_picture_action' => 'nullable|string|in:upload,delete',
        ], [
            'mobile.regex' => 'Format nomor HP tidak valid. Gunakan format 08xxxxxxxxxx atau 628xxxxxxxxxx',
            'mobile.unique' => 'Nomor HP sudah digunakan oleh pengguna lain',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain',
            'profile_picture.image' => 'File harus berupa gambar',
            'profile_picture.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif',
            'profile_picture.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Handle foto profil
            $oldProfilePicture = $user->profile_picture;
            $newProfilePicture = $oldProfilePicture;

            // Jika ada aksi untuk foto profil
            if ($request->filled('profile_picture_action')) {
                $action = $request->profile_picture_action;

                if ($action === 'upload' && $request->hasFile('profile_picture')) {
                    // Upload foto profil baru
                    $file = $request->file('profile_picture');
                    $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

                    // Pastikan folder ada
                    $uploadPath = public_path('uploads/foto_profile');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    // Pindahkan file ke folder uploads/foto_profile
                    $file->move($uploadPath, $filename);

                    // Path relatif untuk disimpan di database
                    $newProfilePicture = 'uploads/foto_profile/' . $filename;

                    // Hapus foto lama jika ada
                    if ($oldProfilePicture && file_exists(public_path($oldProfilePicture))) {
                        unlink(public_path($oldProfilePicture));
                    }
                } elseif ($action === 'delete') {
                    // Hapus foto profil
                    if ($oldProfilePicture && file_exists(public_path($oldProfilePicture))) {
                        unlink(public_path($oldProfilePicture));
                    }
                    $newProfilePicture = null;
                }
            }

            // Update informasi akun dasar
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->bio = $request->bio;
            $user->profile_picture = $newProfilePicture;

            // Cek apakah email berubah
            $emailChanged = $user->email !== $request->email;
            if ($emailChanged) {
                $user->email = $request->email;
                $user->email_verified_at = null; // Reset verifikasi email
            }

            // Periksa apakah semua field password diisi
            if ($request->filled('old_password') && $request->filled('new_password') && $request->filled('new_password_confirmation')) {
                // Validasi kata sandi
                $passwordValidator = Validator::make($request->all(), [
                    'old_password' => 'required|string',
                    'new_password' => [
                        'required',
                        'string',
                        'min:8',
                        'different:old_password',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_+={}\[\]:;<>,.~\\\-]).{8,}$/'
                    ],
                    'new_password_confirmation' => 'required|same:new_password',
                ], [
                    'new_password.regex' => 'Kata sandi harus mengandung minimal 1 huruf kecil, 1 huruf besar, 1 angka, dan 1 simbol',
                    'new_password.different' => 'Kata sandi baru harus berbeda dengan kata sandi lama',
                    'new_password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok',
                ]);

                if ($passwordValidator->fails()) {
                    return redirect()->back()
                        ->withErrors($passwordValidator)
                        ->withInput();
                }

                // Verifikasi kata sandi lama
                if (!Hash::check($request->old_password, $user->password)) {
                    return redirect()->back()
                        ->withErrors(['old_password' => 'Kata sandi lama tidak cocok'])
                        ->withInput();
                }

                // Perbarui kata sandi
                $user->password = Hash::make($request->new_password);
                $successMessage = 'Detail akun dan kata sandi berhasil diperbarui';
            } else {
                // Jika ada salah satu field password yang diisi tapi tidak lengkap
                if ($request->filled('old_password') || $request->filled('new_password') || $request->filled('new_password_confirmation')) {
                    return redirect()->back()
                        ->withErrors(['password_error' => 'Jika ingin mengubah kata sandi, semua field kata sandi harus diisi'])
                        ->withInput();
                }

                $successMessage = 'Detail akun berhasil diperbarui';
            }

            // Simpan perubahan
            $user->save();

            DB::commit();

            // Pesan sukses dengan informasi tambahan
            if ($emailChanged) {
                $successMessage .= '. Email Anda telah berubah dan memerlukan verifikasi ulang.';
            }

            if ($request->filled('profile_picture_action') && $request->profile_picture_action === 'upload') {
                $successMessage .= ' Foto profil berhasil diperbarui.';
            } elseif ($request->filled('profile_picture_action') && $request->profile_picture_action === 'delete') {
                $successMessage .= ' Foto profil berhasil dihapus.';
            }

            return redirect()->route('user.accountdetails.account-details')
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollback();

            // Jika ada file yang sudah diupload tapi gagal save, hapus file tersebut
            if (isset($newProfilePicture) && $newProfilePicture !== $oldProfilePicture && file_exists(public_path($newProfilePicture))) {
                unlink(public_path($newProfilePicture));
            }

            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    // ====================================================================================================
    // Upload Payment Proof
    // ====================================================================================================
    public function uploadPaymentProof(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048' // 2MB max
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diupload',
            'payment_proof.mimes' => 'Format file harus JPG, PNG, atau PDF',
            'payment_proof.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            // Find the order and transaction
            $order = Order::where('id', $request->order_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $transaction = Transaction::where('order_id', $order->id)->firstOrFail();

            // Check if transaction is still pending
            if ($transaction->status !== 'pending') {
                return back()->with('error', 'Tidak dapat mengupload bukti untuk transaksi yang sudah diproses.');
            }

            // Handle file upload
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');

                // Generate unique filename
                $fileName = 'payment_proof_' . $transaction->id . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Store file in storage/app/public/payment_proofs
                $filePath = $file->storeAs('payment_proofs', $fileName, 'public');

                // Delete old proof if exists
                if ($transaction->payment_proof) {
                    Storage::disk('public')->delete($transaction->payment_proof);
                }

                // Update transaction with proof
                $transaction->payment_proof = $filePath;
                $transaction->save();

                return back()->with('status', 'Bukti pembayaran berhasil diupload! Admin akan memverifikasi dalam 1x24 jam.');
            }

            return back()->with('error', 'Gagal mengupload file. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('Error uploading payment proof: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran.');
        }
    }

    // ====================================================================================================
    // Download Order Invoice
    // ====================================================================================================
    public function downloadInvoice($order_id)
    {
        $order = Order::with(['orderItems.product', 'transaction'])
            ->where('user_id', Auth::id())
            ->findOrFail($order_id);

        $transaction = $order->transaction;

        // Generate PDF invoice (you'll need to install dompdf or similar)
        $pdf = PDF::loadView('user.invoice', compact('order', 'transaction'));

        $filename = 'Invoice_' . str_pad($order->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }

    // ====================================================================================================
    // Share Order Details
    // ====================================================================================================
    public function shareOrder($order_id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($order_id);

        // Generate shareable link or return JSON for social sharing
        $shareData = [
            'title' => 'Detail Pesanan #' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'description' => 'Pesanan saya di ' . config('app.name'),
            'url' => route('user.account.order.details', $order_id),
            'image' => asset('assets/images/logo.png') // Your app logo
        ];

        return response()->json($shareData);
    }

    // ====================================================================================================
    // Request Order Cancellation with Reason
    // ====================================================================================================
    public function requestCancellation(Request $request, $order_id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
            'details' => 'nullable|string|max:1000'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($order_id);

        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'awaiting_payment', 'confirmed'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan pada status ini.');
        }

        try {
            DB::beginTransaction();

            // Update order status
            $order->status = 'canceled';
            $order->canceled_date = now();
            $order->cancellation_reason = $request->reason;
            $order->cancellation_details = $request->details;
            $order->save();

            // Return stock if needed
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity += $item->quantity;
                    if ($product->reserved_quantity >= $item->quantity) {
                        $product->reserved_quantity -= $item->quantity;
                    }
                    $product->save();
                }
            }

            // Add notification
            DB::table('notifications')->insert([
                'pesan' => 'Pesanan #' . str_pad($order->id, 6, '0', STR_PAD_LEFT) . ' dibatalkan oleh pelanggan',
                'waktu' => now(),
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return back()->with('status', 'Pesanan berhasil dibatalkan. Jika sudah ada pembayaran, refund akan diproses dalam 3-7 hari kerja.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling order: ' . $e->getMessage());
            return back()->with('error', 'Gagal membatalkan pesanan. Silakan coba lagi.');
        }
    }

    // ====================================================================================================
    // Create Dispute/Complaint
    // ====================================================================================================
    public function createDispute(Request $request, $order_id)
    {
        $request->validate([
            'type' => 'required|in:damaged,wrong_item,not_received,quality_issue,other',
            'description' => 'required|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($order_id);

        try {
            // Create dispute record (you'll need to create this table)
            $dispute = DB::table('order_disputes')->insertGetId([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'type' => $request->type,
                'description' => $request->description,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Handle image uploads if any
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $fileName = 'dispute_' . $dispute . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $filePath = $image->storeAs('dispute_images', $fileName, 'public');

                    DB::table('dispute_images')->insert([
                        'dispute_id' => $dispute,
                        'image_path' => $filePath,
                        'created_at' => now()
                    ]);
                }
            }

            return back()->with('status', 'Keluhan berhasil disubmit. Tim customer service akan menghubungi Anda dalam 1x24 jam.');
        } catch (\Exception $e) {
            Log::error('Error creating dispute: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengajukan keluhan. Silakan coba lagi.');
        }
    }

    // ====================================================================================================
    // Get Order Status (API)
    // ====================================================================================================
    public function getOrderStatus($order_id)
    {
        $order = Order::with('transaction')
            ->where('user_id', Auth::id())
            ->findOrFail($order_id);

        return response()->json([
            'order_status' => $order->status,
            'payment_status' => $order->transaction ? $order->transaction->status : null,
            'last_updated' => $order->updated_at->toISOString()
        ]);
    }

    // ====================================================================================================
    // Get Payment Status (API)
    // ====================================================================================================
    public function getPaymentStatus($transaction_id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->findOrFail($transaction_id);

        return response()->json([
            'status' => $transaction->status,
            'last_updated' => $transaction->updated_at->toISOString(),
            'payment_proof' => $transaction->payment_proof ? asset('storage/' . $transaction->payment_proof) : null
        ]);
    }

    // ====================================================================================================
    // Refresh Order Data (API)
    // ====================================================================================================
    public function refreshOrderData($order_id)
    {
        $order = Order::with(['orderItems.product', 'transaction'])
            ->where('user_id', Auth::id())
            ->findOrFail($order_id);

        return response()->json([
            'order' => $order,
            'status_timeline' => $this->getOrderTimeline($order),
            'can_cancel' => in_array($order->status, ['pending', 'awaiting_payment', 'confirmed']),
            'can_confirm' => $order->status === 'delivered'
        ]);
    }

    // ====================================================================================================
    // Get Order Timeline (Helper)
    // ====================================================================================================
    private function getOrderTimeline($order)
    {
        $timeline = [];

        $statuses = [
            'awaiting_payment' => 'Menunggu Pembayaran',
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Sampai Tujuan',
            'completed' => 'Selesai'
        ];

        foreach ($statuses as $status => $label) {
            $dateField = $status . '_date';
            $date = $order->$dateField ?? ($status === 'awaiting_payment' ? $order->created_at : null);

            $timeline[] = [
                'status' => $status,
                'label' => $label,
                'date' => $date ? $date->format('Y-m-d H:i:s') : null,
                'is_completed' => $this->isStatusCompleted($order->status, $status),
                'is_active' => $order->status === $status
            ];
        }

        return $timeline;
    }

    // ====================================================================================================
    // Check if Status is Completed (Helper)
    // ====================================================================================================
    private function isStatusCompleted($currentStatus, $checkStatus)
    {
        $statusOrder = ['awaiting_payment', 'pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed'];

        $currentIndex = array_search($currentStatus, $statusOrder);
        $checkIndex = array_search($checkStatus, $statusOrder);

        if ($currentStatus === 'canceled') {
            return false;
        }

        return $currentIndex !== false && $checkIndex !== false && $currentIndex >= $checkIndex;
    }

    // ====================================================================================================
    // Get Shipping Tracking (API) - Optional integration with shipping providers
    // ====================================================================================================
    public function getShippingTracking($order_id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($order_id);

        // This would integrate with shipping provider APIs (JNE, TIKI, POS, etc.)
        // For now, return mock data

        $trackingData = [
            'tracking_number' => $order->tracking_number ?? 'N/A',
            'courier' => $order->kurir ?? 'N/A',
            'status' => $order->status,
            'estimated_delivery' => null,
            'tracking_history' => []
        ];

        // If you have tracking integration, implement here
        // Example: JNE API, TIKI API, etc.

        return response()->json($trackingData);
    }

    // ====================================================================================================
    // Submit Quick Feedback (API)
    // ====================================================================================================
    public function submitQuickFeedback(Request $request, $order_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($order_id);

        // Save quick feedback (you'll need to create this table)
        DB::table('order_feedback')->updateOrInsert(
            ['order_id' => $order->id, 'user_id' => Auth::id()],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'updated_at' => now()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas feedback Anda!'
        ]);
    }

    // ====================================================================================================
    // Update Delivery Address (before shipped)
    // ====================================================================================================
    public function updateDeliveryAddress(Request $request, $order_id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'zip' => 'required|string|max:10'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($order_id);

        // Check if order can still be updated
        if (!in_array($order->status, ['pending', 'confirmed', 'processing'])) {
            return back()->with('error', 'Alamat tidak dapat diubah setelah pesanan dikirim.');
        }

        try {
            $order->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip
            ]);

            return back()->with('status', 'Alamat pengiriman berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating delivery address: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui alamat pengiriman.');
        }
    }
}
