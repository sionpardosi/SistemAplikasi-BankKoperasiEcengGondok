<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PendingOrder;
use App\Models\StockReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    /**
     * metode MidtransCallbackController
     */
    public function handle(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        Log::info('Midtrans Callback Payload:', $payload);

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;

        $serverKey = config('midtrans.serverKey');
        $hashed = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($hashed !== $signatureKey) {
            Log::warning('Midtrans Signature Tidak Valid', [
                'expected' => $hashed,
                'received' => $signatureKey
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::where('invoice', $orderId)->first();
        if (!$transaction) {
            Log::error('Transaksi tidak ditemukan untuk order_id: ' . $orderId);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        DB::beginTransaction();
        try {
            switch ($transactionStatus) {
                case 'capture':
                case 'settlement':
                    // Update status transaksi
                    $transaction->status = 'approved';
                    $transaction->save();

                    // ✅ PERBAIKAN: Tambahkan logic pengurangan stok
                    if ($transaction->pending_order_id) {
                        // Untuk sistem pending order (jika Anda menggunakannya)
                        $pendingOrder = PendingOrder::with(['items', 'stockReservations'])->find($transaction->pending_order_id);

                        if ($pendingOrder && $pendingOrder->status === 'pending_payment') {
                            // Konversi ke order sesungguhnya
                            $order = $pendingOrder->convertToOrder();

                            // Update transaksi
                            $transaction->order_id = $order->id;
                            $transaction->save();

                            Log::info("Pending order {$pendingOrder->id} converted to order {$order->id}");
                        }
                    } else {
                        // ✅ PERBAIKAN UTAMA: Untuk sistem order langsung (yang Anda gunakan)
                        if ($transaction->order_id) {
                            $order = Order::find($transaction->order_id);
                            if ($order) {
                                // Update status order menjadi confirmed
                                $order->status = 'confirmed';
                                $order->confirmed_date = now();
                                $order->save();

                                // ✅ PERBAIKAN: Kurangi stok produk berdasarkan order items
                                $this->reduceProductStock($order);

                                Log::info("Order {$order->id} status updated to confirmed and stock reduced");
                            }
                        }
                    }
                    break;

                case 'expire':
                case 'cancel':
                case 'deny':
                    $transaction->status = 'declined';
                    $transaction->save();

                    // ✅ PERBAIKAN: Release stock reservations
                    if ($transaction->pending_order_id) {
                        $pendingOrder = PendingOrder::with('stockReservations')->find($transaction->pending_order_id);

                        if ($pendingOrder) {
                            // Release semua stock reservations
                            foreach ($pendingOrder->stockReservations()->where('status', 'active')->get() as $reservation) {
                                $reservation->release();
                            }

                            $pendingOrder->status = 'expired';
                            $pendingOrder->save();

                            Log::info("Pending order {$pendingOrder->id} expired and stock released");
                        }
                    } else {
                        // ✅ PERBAIKAN: Release reserved stock untuk order langsung
                        if ($transaction->order_id) {
                            $order = Order::find($transaction->order_id);
                            if ($order) {
                                $order->status = 'canceled';
                                $order->canceled_date = now();
                                $order->save();

                                // Release reserved stock
                                $this->releaseReservedStock($order);

                                Log::info("Order {$order->id} status updated to canceled and reserved stock released");
                            }
                        }
                    }
                    break;

                case 'pending':
                    // Tetap dalam status menunggu pembayaran
                    $transaction->status = 'pending';
                    $transaction->save();
                    break;
            }

            DB::commit();
            Log::info('Status transaksi diperbarui untuk ' . $orderId . ' menjadi ' . $transaction->status);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Midtrans webhook: ' . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }

        return response()->json(['message' => 'Callback handled']);
    }

    /**
     * ✅ METHOD DIPERBAIKI: Kurangi stok produk ketika pembayaran berhasil
     */
    private function reduceProductStock(Order $order)
    {
        foreach ($order->orderItems as $orderItem) {
            $product = Product::lockForUpdate()->find($orderItem->product_id);

            if ($product) {
                Log::info("Processing stock reduction for product {$product->id}, quantity: {$orderItem->quantity}");

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

                    Log::info("Product {$product->id} has sizes, reducing size {$sizeId} stock");

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

                        Log::info("✅ Size stock reduced for product {$product->id} size {$sizeId} by {$orderItem->quantity}");
                    } else {
                        Log::warning("❌ Insufficient size stock for product {$product->id} size {$sizeId}");
                    }
                } else {
                    // ✅ PERBAIKAN: Untuk produk TANPA ukuran, pastikan stok utama berkurang
                    Log::info("Product {$product->id} has NO sizes, reducing main stock");
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

                    Log::info("✅ Product {$product->id} main stock reduced: {$oldQuantity} -> {$product->quantity}, reserved: {$oldReserved} -> {$product->reserved_quantity}");
                } else {
                    Log::warning("❌ Insufficient main stock for product {$product->id}. Available: {$product->quantity}, Reserved: {$product->reserved_quantity}, Needed: {$orderItem->quantity}");
                }
            } else {
                Log::error("❌ Product {$orderItem->product_id} not found");
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

    public function paymentSuccess()
    {
        return redirect('account-orders');
    }

    public function paymentPending()
    {
        return redirect('account-orders');
    }
}
