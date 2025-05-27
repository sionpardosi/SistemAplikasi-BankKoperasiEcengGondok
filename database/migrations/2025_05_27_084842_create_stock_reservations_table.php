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
        Schema::create('stock_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('pending_order_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('reserved_quantity');
            $table->timestamp('expires_at');
            $table->enum('status', ['active', 'released', 'converted'])->default('active');
            $table->timestamps();

            $table->index('expires_at');
            $table->index(['product_id', 'status']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_reservations');
    }
};
