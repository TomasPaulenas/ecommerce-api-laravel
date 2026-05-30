<?php

namespace App\Domain\Order\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)
            ->with('items.product')
            ->first();

        if (!$cart) {
            return response()->json([
                'message' => 'cart not found',
            ], 404);
        }

        if ($cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty',
            ], 400);
        }

        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return response()->json([
                    'message' => 'Insufficient stock',
                    'product_id' => $item->product->id,
                    'product_name' => $item->product->name,
                    'available_stock' => $item->product->stock,
                    'requested_quantity' => $item->quantity,
                ], 400);
            }
        }

        $total = 0;

        foreach ($cart->items as $item) {
            $total += $item->quantity * $item->product->price;
        }

        $order = Order::create([
            'user_id' => $user->id,
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

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ], 201);
    }

    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items.product')
            ->get();

        return response()->json($orders);
    }

    public function show(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->with('items.product')
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json($order);
    }

    public function adminIndex()
    {
        $orders = Order::with('items.product', 'user')->get();

        return response()->json($orders);
    }

    public function adminShow($id)
    {
        $order = Order::with('items.product', 'user')->find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,cancelled,completed',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order,
        ]);
    }
}
