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
            'category' => 'nullable|integer',
            'image' => 'nullable|image|max:2048', // Add validation for image file (max 2MB)
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('product_photo'), $imageName);
            $validatedData['product_pict'] = 'product_photo/' . $imageName; // Save the path relative to the public directory
        } else {
            $validatedData['product_pict'] = null; // Set to null if no image is uploaded
        }

        // Remove image_base64 if it exists in validatedData as we are now saving the path
        unset($validatedData['image_base64']);

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
            'category' => 'nullable|integer|in:1,2,3',
            'image' => 'nullable|image|max:2048', // Add validation for image file (max 2MB)
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->product_pict && file_exists(public_path($product->product_pict))) {
                unlink(public_path($product->product_pict));
            }

            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('product_photo'), $imageName);
            $validatedData['product_pict'] = 'product_photo/' . $imageName; // Save the path relative to the public directory
        }

        $product->update($validatedData);

        return redirect()->route('staff.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Delete the specified product (soft delete).
     */
    public function delete(Product $product): RedirectResponse
    {
        $product->update(['is_deleted' => true]);

        return redirect()->route('staff.products.index')->with('success', 'Product soft deleted successfully!');
    }
}
