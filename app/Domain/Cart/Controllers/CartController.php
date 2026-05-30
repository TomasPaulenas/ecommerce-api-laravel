<?php

namespace App\Domain\Cart\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;


class CartController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
        ]);

        $product = Product::findOrFail($data['product_id']);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $cartItem->quantity + $data['quantity'];
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'unit_price' => $product->price,
            ]);
        }



        return response()->json([
            'message' => 'Product added to cart',
            'cart_item' => $cartItem,
        ], 201);
    }

    public function show(Request $request)
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)
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
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return response()->json([
                'message' => 'Cart not found',
            ], 404);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'message' => 'Cart item not found',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'message' => 'Cart item deleted successfully',
        ]);
    }

    public function patch(Request $request, $id)
    {

        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return response()->json([
                'message' => 'Cart not found',
            ], 404);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'message' => 'Cart item not found',
            ], 404);
        }

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update([
            'quantity' => $data['quantity'],
        ]);
        $cartItem->save();

        return response()->json([
            'cart_item' => $cartItem
        ]);
    }
}
