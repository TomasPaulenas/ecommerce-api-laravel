<?php

namespace App\Domain\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

        $products =  Product::with('category')->where('is_active', true)->get();




        return response()->json($products);
    }
    public function store(Request $request)
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

        $product = Product::create($data);
        $product->load('category');

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

    public function update(Request $request, int $id)
    {

        $product = Product::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();


        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image_url' => 'sometimes|nullable|string',
            'is_active' => 'sometimes|boolean'
        ]);

        $product->update($data);

        $product->load('category');
        return response()->json($product);
    }

    public function destroy(int $id)
    {

        $product = Product::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        $product->update(['is_active' => false]);

        return response()->json([
            'message' => 'Product deactivated',
            'product' => $product
        ]);
    }
}
