<?php

namespace App\Domain\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Domain\Products\Actions\CreateProductAction;
use App\Domain\Products\Actions\UpdateProductAction;
use App\Domain\Products\Actions\DeactivateProductAction;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->get();

        return response()->json($products);
    }

    public function store(Request $request, CreateProductAction $action)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $product = $action->execute($data);

        return response()->json($product, 201);
    }

    public function show(int $id)
    {
        $product = Product::where('id', $id)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        return response()->json($product);
    }

    public function update(Request $request, int $id, UpdateProductAction $action)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image_url' => 'sometimes|nullable|string',
            'is_active' => 'sometimes|boolean'
        ]);

        $product = $action->execute($id, $data);

        return response()->json($product);
    }

    public function destroy(int $id, DeactivateProductAction $action)
    {
        $product = $action->execute($id);

        return response()->json([
            'message' => 'Product deactivated',
            'product' => $product
        ]);
    }
}
