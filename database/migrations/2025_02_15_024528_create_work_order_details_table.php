<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_order_details', function (Blueprint $table) {
            $table->id(); // id (PK)
            $table->foreignId('work_order_id')->constrained('work_orders'); // work_orders_id (FK) referencing work_orders table
            $table->foreignId('product_id')->constrained('products'); // product_id (FK) referencing products table
            $table->integer('qty'); // Quantity
            $table->decimal('harga', 10, 2); // Price per item, DECIMAL
            $table->decimal('sub_total', 10, 2); // Subtotal, DECIMAL
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_details');
    }
};