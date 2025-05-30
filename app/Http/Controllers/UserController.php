<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\SupplierRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PendingOrder;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view("user.index");
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
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('user.order-details', compact('order', 'orderItems', 'transaction'));
    }

    public function account_cancel_order(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = "canceled";
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with("status", "Order has been cancelled successfully!");
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

        // Validasi input dasar (nama, email, dan nomor HP)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|min:10|max:15|unique:users,mobile,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Memperbarui informasi akun dasar
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;

            // Periksa apakah semua field password diisi
            if ($request->filled('old_password') && $request->filled('new_password') && $request->filled('new_password_confirmation')) {
                // Validasi kata sandi
                $passwordValidator = Validator::make($request->all(), [
                    'old_password' => 'required|string',
                    'new_password' => 'required|string|min:8|different:old_password',
                    'new_password_confirmation' => 'required|same:new_password',
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

            // Simpan perubahan dengan menggunakan metode update()
            // Untuk menghindari error pada save()
            $user->update([
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'password' => $user->password
            ]);

            DB::commit();

            return redirect()->route('user.accountdetails.account-details')
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
