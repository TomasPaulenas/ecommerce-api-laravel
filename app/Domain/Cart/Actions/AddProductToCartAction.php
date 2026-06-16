<?php

namespace App\Domain\Cart\Actions;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\User;

class AddProductToCartAction
{
    public function execute(User $user, array $data): CartItem
    {
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
        ]);

        $product = Product::findOrFail($data['product_id']);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $data['quantity'];
            $cartItem->save();

            return $cartItem;
        }

        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'unit_price' => $product->price,
        ]);
    }
}
