<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\PendingOrder;
use App\Models\Product;
use App\Models\StockReservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpireAwaitingPaymentOrders extends Command
{
    protected $signature = 'orders:expire-pending';
    protected $description = 'Expire pending orders and release stock reservations';

    // Di ExpireAwaitingPaymentOrders.php
    public function handle()
    {
        // Temukan pesanan yang belum dibayar setelah 1 jam (bukan 24 jam)
        $expiredOrders = Order::where('status', 'awaiting_payment')
            ->where('created_at', '<', now()->subHour())
            ->get();

        $count = 0;
        foreach ($expiredOrders as $order) {
            DB::beginTransaction();
            try {
                // Update status order
                $order->status = 'canceled';
                $order->canceled_date = now();
                $order->save();

                // Update transaksi jika ada
                if ($order->transaction) {
                    $order->transaction->status = 'declined';
                    $order->transaction->save();
                }

                // Kembalikan reserved_quantity
                foreach ($order->orderItems as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product) {
                        $product->reserved_quantity -= $item->quantity;
                        if ($product->reserved_quantity < 0) {
                            $product->reserved_quantity = 0;
                        }
                        $product->save();
                    }
                }

                DB::commit();
                $count++;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to expire order #' . $order->id . ': ' . $e->getMessage());
            }
        }

        $this->info("Successfully expired {$count} awaiting payment orders.");
    }
}
