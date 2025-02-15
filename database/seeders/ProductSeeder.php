<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'nama' => 'Espresso',
                'deskripsi' => 'Strong black coffee',
                'harga' => 3.50,
                'product_pict' => 'https://placehold.co/500x500', // Placeholder image URL
            ],
            [
                'nama' => 'Cappuccino',
                'deskripsi' => 'Espresso with steamed milk and foam',
                'harga' => 4.00,
                'product_pict' => 'https://placehold.co/500x500', // Placeholder image URL
            ],
            [
                'nama' => 'Latte',
                'deskripsi' => 'Espresso with steamed milk',
                'harga' => 4.00,
                'product_pict' => 'https://placehold.co/500x500', // Placeholder image URL
            ],
            [
                'nama' => 'Americano',
                'deskripsi' => 'Espresso diluted with hot water',
                'harga' => 3.75,
                'product_pict' => 'https://placehold.co/500x500', // Placeholder image URL
            ],
            [
                'nama' => 'Mocha',
                'deskripsi' => 'Espresso with chocolate syrup and milk',
                'harga' => 4.50,
                'product_pict' => 'https://placehold.co/500x500', // Placeholder image URL
            ],
            [
                'nama' => 'Croissant',
                'deskripsi' => 'Buttery pastry',
                'harga' => 2.50,
                'product_pict' => 'https://placehold.co/500x500', // Placeholder image URL
            ],
            [
                'nama' => 'Muffin',
                'deskripsi' => 'Assorted flavors available',
                'harga' => 3.00,
                'product_pict' => 'https://placehold.co/500x500', // Placeholder image URL
            ],
            [
                'nama' => 'Cheesecake',
                'deskripsi' => 'Classic New York style cheesecake',
                'harga' => 5.00,
                'product_pict' => 'https://placehold.co/500x500', // Placeholder image URL
            ],
            // Add more menu items as needed...
        ]);
    }
}