<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    public function index(Request $request)
    {
        $business = $request->user()->currentBusiness();
        if (!$business) {
            return response()->json(['error' => 'No business found'], 404);
        }

        $products = Product::where('business_id', $business->id)
            ->orderBy('name')
            ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $business = $request->user()->currentBusiness();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = $business->products()->create($validated);

        return response()->json($product, 201);
    }

    public function show(Request $request, Product $product)
    {
        $business = $request->user()->currentBusiness();
        if ($product->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $business = $request->user()->currentBusiness();
        if ($product->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy(Request $request, Product $product)
    {
        $business = $request->user()->currentBusiness();
        if ($product->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
