<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StaffProductController extends Controller
{
    /**
     * Display a listing of the products for staff management.
     */
    public function index(): View
    {
        $products = Product::latest()->get(); // Fetch all products, newest first
        return view('staff.products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        return view('staff.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'product_pict' => 'nullable|url|max:255', // Basic URL validation for product picture
        ]);

        Product::create($validatedData);

        return redirect()->route('staff.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        return view('staff.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'product_pict' => 'nullable|url|max:255', // Basic URL validation for product picture
        ]);

        $product->update($validatedData);

        return redirect()->route('staff.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('staff.products.index')->with('success', 'Product deleted successfully!');
    }
}