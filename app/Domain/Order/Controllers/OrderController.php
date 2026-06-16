<?php

namespace App\Domain\Order\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Domain\Order\Actions\CreateOrderFromCartAction;
use App\Domain\Order\Actions\UpdateOrderStatusAction;


class OrderController extends Controller
{
    public function store(Request $request, CreateOrderFromCartAction $createOrderFromCartAction)
    {
        $order = $createOrderFromCartAction->execute($request->user());

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

    public function updateStatus(Request $request, $id, UpdateOrderStatusAction $updateOrderStatusAction)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,paid,shipped,cancelled,completed',
        ]);

        $order = $updateOrderStatusAction->execute($id, $data['status']);

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order,
        ]);
    }
}
