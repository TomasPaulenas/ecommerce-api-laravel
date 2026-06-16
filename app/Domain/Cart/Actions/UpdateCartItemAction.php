<?php

namespace App\Domain\Cart\Actions;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;

class UpdateCartItemAction
{
    public function execute(User $user, int $cartItemId, int $quantity): CartItem
    {
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            abort(response()->json([
                'message' => 'Cart not found',
            ], 404));
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $cartItemId)
            ->first();

        if (!$cartItem) {
            abort(response()->json([
                'message' => 'Cart item not found',
            ], 404));
        }

        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return $cartItem;
    }
}
