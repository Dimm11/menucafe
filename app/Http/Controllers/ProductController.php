<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the products (menu items), optionally filtered by table.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $tableId = $request->query('table'); // Ambil parameter 'table' dari query string

        if ($tableId && is_numeric($tableId)) {
            // Jika parameter 'table' ada dan berupa angka, kita filter produk (opsional)
            // Saat ini, kita tetap mengambil semua produk.
            // Anda bisa menambahkan logika filter produk berdasarkan $tableId di sini jika diperlukan.
            $products = Product::all();

            return view('products.index', [
                'products' => $products,
                'tableId' => $tableId, // Kirim tableId ke view agar bisa digunakan
            ]);
        } else {
            // Jika parameter 'table' tidak ada atau bukan angka, tampilkan semua produk
            $products = Product::all();

            return view('products.index', ['products' => $products]);
        }
    }

    // Fungsi lain seperti create, edit, dll. bisa ditambahkan di sini jika diperlukan.
}