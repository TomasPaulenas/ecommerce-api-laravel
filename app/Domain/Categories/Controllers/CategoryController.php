<?php

namespace App\Domain\Categories\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {

        $categories = Category::all();
        return response()->json($categories);
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|,max:255',
            'description' => 'nullable|string'
        ]);



        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return response()->json($category, 201);
    }


    public function show(string $id)
    {

        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json($category);
    }


    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
