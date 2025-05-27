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
                    // PERUBAHAN: Konversi pending order menjadi order sesungguhnya
                    if ($transaction->pending_order_id) {
                        $pendingOrder = PendingOrder::with(['items', 'stockReservations'])->find($transaction->pending_order_id);

                        if ($pendingOrder && $pendingOrder->status === 'pending_payment') {
                            // Konversi ke order sesungguhnya
                            $order = $pendingOrder->convertToOrder();

                            // Update transaksi
                            $transaction->order_id = $order->id;
                            $transaction->status = 'approved';
                            $transaction->save();

                            Log::info("Pending order {$pendingOrder->id} converted to order {$order->id}");
                        }
                    } else {
                        // Fallback untuk transaksi lama
                        $transaction->status = 'approved';
                        $transaction->save();

                        if ($transaction->order_id) {
                            $order = Order::find($transaction->order_id);
                            if ($order) {
                                $order->status = 'confirmed';
                                $order->confirmed_date = now();
                                $order->save();
                            }
                        }
                    }
                    break;

                case 'expire':
                case 'cancel':
                case 'deny':
                    // PERUBAHAN: Release semua reservasi stok
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
                        // Fallback untuk transaksi lama
                        if ($transaction->order_id) {
                            $order = Order::find($transaction->order_id);
                            if ($order) {
                                $order->status = 'canceled';
                                $order->canceled_date = now();
                                $order->save();
                            }
                        }
                    }

                    $transaction->status = 'declined';
                    $transaction->save();
                    break;

                case 'pending':
                    // Tetap dalam status menunggu pembayaran
                    $transaction->status = 'pending';
                    $transaction->save();
                    break;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Midtrans webhook: ' . $e->getMessage());
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
