<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        // Logic to retrieve and return all suppliers
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    public function show(Supplier $supplier)
    {
        // Logic to retrieve and return a specific supplier by ID
        return response()->json($supplier);
    }

    public function store(Request $request)
    {
        // Logic to create a new supplier
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|string|email|max:255|unique:suppliers,contact_email',
        ]);

        $supplier = Supplier::create($request->all());

        return response()->json($supplier, 201); // Return the created supplier with a 201 status code
    }

    public function update(Request $request, Supplier $supplier)
    {
        // Logic to update an existing supplier
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'contact_name' => 'sometimes|string|max:255',
            'contact_email' => 'sometimes|string|email|max:255|unique:suppliers,contact_email,' . $supplier->id,
        ]);

        $supplier->update($request->all());

        return response()->json(['message' => 'Supplier updated successfully', 'supplier' => $supplier]);
    }

    public function destroy(Supplier $supplier)
    {
        // Logic to delete a supplier
        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully'], 200);
    }
}
