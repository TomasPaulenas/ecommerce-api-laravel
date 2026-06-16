<?php

namespace App\Domain\Order\Actions;

use App\Models\Order;

class UpdateOrderStatusAction
{
    public function execute(int $orderId, string $status): Order
    {
        $order = Order::find($orderId);

        if (!$order) {
            abort(response()->json([
                'message' => 'Order not found'
            ], 404));
        }

        $order->status = $status;
        $order->save();

        return $order;
    }
}
