<?php

namespace App\Http\Controllers;

use App\Models\Product; // Import the Product model
use Illuminate\Http\Request;
use Illuminate\View\View; // Import the View class

class ProductController extends Controller
{
    /**
     * Display a listing of the products (menu items).
     */
    public function index(): View
    {
        $products = Product::all(); // Fetch all products from the database

        return view('products.index', ['products' => $products]); // Pass the products data to the 'products.index' view
    }

    public function cart()
    {
        return view('products.cart'); // Render the cart view
    }

    public function checkout()
    {
        return view('products.checkout');
    }

    // We'll add more actions (methods) later for creating, editing, etc., if needed.
}