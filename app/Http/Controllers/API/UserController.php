<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    // Menampilkan daftar order pengguna
    public function accountOrders()
    {
        try {
            $user = Auth::guard('sanctum')->user();

            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            return $this->sendResponse($orders, 'User orders retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve user orders', ['error' => $e->getMessage()], 500);
        }
    }

    // Menampilkan detail order pengguna berdasarkan order_id
    public function accountOrderDetails($order_id)
    {
        try {
            $user = Auth::guard('sanctum')->user();

            $order = Order::where('user_id', $user->id)->find($order_id);
            if (!$order) {
                return $this->sendError('Order not found', [], 404);
            }

            $orderItems = OrderItem::where('order_id', $order_id)
                ->orderBy('id')
                ->paginate(12);

            $transaction = Transaction::where('order_id', $order_id)->first();

            return $this->sendResponse([
                'order' => $order,
                'orderItems' => $orderItems,
                'transaction' => $transaction
            ], 'Order details retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve order details', ['error' => $e->getMessage()], 500);
        }
    }

    // Membatalkan order
    public function accountCancelOrder(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();

            $request->validate([
                'order_id' => 'required|exists:orders,id'
            ]);

            $order = Order::where('user_id', $user->id)->find($request->order_id);
            if (!$order) {
                return $this->sendError('Order not found or not owned by the user', [], 404);
            }

            $order->status = "canceled";
            $order->canceled_date = Carbon::now();
            $order->save();

            return $this->sendResponse([], 'Order has been cancelled successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to cancel order', ['error' => $e->getMessage()], 500);
        }
    }
}
