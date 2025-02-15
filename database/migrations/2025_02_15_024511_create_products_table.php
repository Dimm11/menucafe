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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id (PK)
            $table->string('nama'); // Product name
            $table->text('deskripsi')->nullable(); // Product description, text type for longer descriptions, nullable
            $table->decimal('harga', 10, 2); // Price, DECIMAL(10, 2) for currency (10 digits total, 2 after decimal point)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};