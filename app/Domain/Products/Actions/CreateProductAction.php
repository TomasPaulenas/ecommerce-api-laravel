<?php

namespace App\Domain\Products\Actions;

use App\Models\Product;

class CreateProductAction
{
    public function execute(array $data): Product
    {
        $product = Product::create($data);

        return $product->load('category');
    }
}
