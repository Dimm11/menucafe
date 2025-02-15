<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'preparing', 'served', 'completed'])->nullable()->change(); // Change status column to enum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('status')->nullable()->change(); // Revert back to string if needed (for rollback)
            // If you added default values or other constraints to status before, you'd revert those here too.
        });
    }
};