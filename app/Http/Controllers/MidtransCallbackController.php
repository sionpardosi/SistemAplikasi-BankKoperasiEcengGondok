<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
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

        $order = $transaction->order;
        if (!$order) {
            Log::error('Order tidak ditemukan untuk transaksi: ' . $orderId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        DB::beginTransaction();
        try {
            switch ($transactionStatus) {
                case 'capture':
                case 'settlement':
                    // Update transaksi dan order status
                    $transaction->status = 'paid';
                    $transaction->save();

                    $order->status = 'confirmed';
                    $order->confirmed_date = now();
                    $order->save();

                    // Kurangi stok permanen dan reserved_quantity
                    foreach ($order->orderItems as $item) {
                        $product = Product::lockForUpdate()->find($item->product_id);

                        // Pastikan stok cukup (jika tidak, bisa log error)
                        if ($product->quantity < $item->quantity) {
                            Log::error("Stok produk {$product->name} tidak cukup saat konfirmasi pembayaran.");
                            continue;
                        }

                        $product->quantity -= $item->quantity;
                        $product->reserved_quantity -= $item->quantity;
                        if ($product->reserved_quantity < 0) {
                            $product->reserved_quantity = 0; // safety
                        }
                        $product->save();
                    }
                    break;

                case 'expire':
                case 'cancel':
                case 'deny':
                    // Update transaksi dan order status
                    $transaction->status = 'failed';
                    $transaction->save();

                    $order->status = 'canceled';
                    $order->canceled_date = now();
                    $order->save();

                    // Kembalikan reserved_quantity ke stok permanen (hapus reserved)
                    foreach ($order->orderItems as $item) {
                        $product = Product::lockForUpdate()->find($item->product_id);

                        $product->reserved_quantity -= $item->quantity;
                        if ($product->reserved_quantity < 0) {
                            $product->reserved_quantity = 0;
                        }
                        $product->save();
                    }
                    break;

                case 'pending':
                    // Status pending, tidak kurangi stok permanen, hanya tunggu pembayaran
                    $transaction->status = 'pending';
                    $transaction->save();
                    break;

                default:
                    // Status lain, biarkan seperti semula
                    break;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error update stok Midtrans webhook: ' . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }

        Log::info('Status transaksi diperbarui untuk ' . $orderId . ' menjadi ' . $transaction->status);

        return response()->json(['message' => 'Callback handled']);
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
