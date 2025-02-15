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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id(); // id (PK)
            $table->string('nama'); // Work order name/description
            $table->string('no_telp')->nullable(); // Phone number, nullable as it might be optional
            $table->string('no_meja')->nullable(); // Table number, nullable
            $table->string('status')->nullable(); // Status of the work order, nullable
            $table->string('work_numbers')->nullable(); // Work order numbers, nullable
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};