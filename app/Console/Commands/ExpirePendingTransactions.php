<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpirePendingTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-pending-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTransactions = Transaction::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(24))
            ->get();

        foreach ($expiredTransactions as $transaction) {
            DB::beginTransaction();
            try {
                $order = $transaction->order;

                // Update status transaksi dan order
                $transaction->status = 'failed';
                $transaction->save();

                $order->status = 'canceled';
                $order->canceled_date = now();
                $order->save();

                // Kembalikan reserved_quantity ke stok permanen
                foreach ($order->orderItems as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    $product->reserved_quantity -= $item->quantity;
                    if ($product->reserved_quantity < 0) {
                        $product->reserved_quantity = 0;
                    }
                    $product->save();
                }

                DB::commit();

                Log::info("Transaksi {$transaction->id} expired dan stok dikembalikan.");
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Gagal memproses expired transaksi {$transaction->id}: " . $e->getMessage());
            }
        }
    }

}
