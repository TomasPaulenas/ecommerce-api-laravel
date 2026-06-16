<?php

namespace App\Domain\Order\Actions;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateOrderFromCartAction
{
    public function execute(User $user): Order
    {
        $cart = Cart::where('user_id', $user->id)
            ->with('items.product')
            ->first();

        if (!$cart) {
            abort(response()->json([
                'message' => 'cart not found',
            ], 404));
        }

        if ($cart->items->isEmpty()) {
            abort(response()->json([
                'message' => 'Cart is empty',
            ], 400));
        }

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                abort(response()->json([
                    'message' => 'Insufficient stock',
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'available_stock' => $item->product->stock,
                    'requested_quantity' => $item->quantity,
                ], 400));
            }
        }

        $total = 0;

        foreach ($cart->items as $item) {
            $total += $item->quantity * $item->product->price;
        }

        return DB::transaction(function () use ($cart, $total) {
            $order = Order::create([
                'user_id' => $cart->user_id,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cart->items as $item) {
                $subtotal = $item->quantity * $item->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                    'subtotal' => $subtotal,
                ]);

                $item->product->stock -= $item->quantity;
                $item->product->save();
            }

            $cart->items()->delete();

            return $order->load('items.product');
        });
    }
}
