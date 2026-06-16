<?php

namespace App\Domain\Cart\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Domain\Cart\Actions\AddProductToCartAction;
use App\Domain\Cart\Actions\RemoveCartItemAction;
use App\Domain\Cart\Actions\UpdateCartItemAction;

class CartController extends Controller
{
    public function store(Request $request, AddProductToCartAction $action)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = $action->execute($request->user(), $data);

        return response()->json([
            'message' => 'Product added to cart',
            'cart_item' => $cartItem,
        ], 201);
    }

    public function show(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)
            ->with('items.product')
            ->first();

        if (!$cart) {
            return response()->json([
                'items' => [],
                'total' => 0,
            ]);
        }

        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });

        return response()->json([
            'items' => $cart->items,
            'total' => $total,
        ]);
    }

    public function destroy(Request $request, $id, RemoveCartItemAction $action)
    {
        $action->execute($request->user(), $id);

        return response()->json([
            'message' => 'Cart item deleted successfully',
        ]);
    }

    public function patch(Request $request, $id, UpdateCartItemAction $action)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = $action->execute(
            $request->user(),
            $id,
            $data['quantity']
        );

        return response()->json([
            'cart_item' => $cartItem,
        ]);
    }
}
