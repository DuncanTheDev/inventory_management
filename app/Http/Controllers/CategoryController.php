<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all(); // Logic to retrieve and return all categories
        return response()->json($categories);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create($request->all());

        return response()->json($category, 201); // Logic to create a new category
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->all());

        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    public function destroy(Category $category)
    {
        $category->delete(); // Logic to delete a category

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
