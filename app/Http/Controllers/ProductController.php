<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query(['supplier', 'category']);

        //search by name
        if($request->has('search')){
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        //filter by category
        if($request->has('category')){
            $query->whereHas('category', fn($q) => $q->where('name', $request->category));
        }

        //filter by supplier
        if($request->has('supplier')){
            $query->whereHas('supplier', fn($q) => $q->where('name', $request->supplier));
        }

        //filter by price range
        if($request->min('price')){
            $query->where('price', '>=', $request->min('price'));
        }
        if($request->max('price')){
            $query->where('price', '<=', $request->max('price'));
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        // Logic to create a new product
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201); // Return the created product with a 201 status code
    }

    public function update(Request $request, Product $product)
    {
        // Logic to update an existing product
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'supplier_id' => 'sometimes|exists:suppliers,id',
        ]);

        $product->update($request->all());

        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    public function destroy(Product $product)
    {
        // Logic to delete a product
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
