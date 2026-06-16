<?php

namespace App\Domain\Products\Actions;

use App\Models\Product;

class UpdateProductAction
{
    public function execute(int $productId, array $data): Product
    {
        $product = Product::where('id', $productId)
            ->where('is_active', true)
            ->firstOrFail();

        $product->update($data);

        return $product->load('category');
    }
}
