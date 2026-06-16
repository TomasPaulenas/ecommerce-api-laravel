<?php

namespace App\Domain\Products\Actions;

use App\Models\Product;

class DeactivateProductAction
{
    public function execute(int $productId): Product
    {
        $product = Product::where('id', $productId)
            ->where('is_active', true)
            ->firstOrFail();

        $product->update([
            'is_active' => false,
        ]);

        return $product;
    }
}
