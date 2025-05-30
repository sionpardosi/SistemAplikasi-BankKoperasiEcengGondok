<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('pending_order_id')->unsigned();
            $table->integer('reserved_quantity')->unsigned();
            $table->timestamp('expires_at');
            $table->enum('status', ['active', 'released', 'converted'])->default('active');

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('pending_order_id')->references('id')->on('pending_orders')->onDelete('cascade');
            $table->index(['expires_at']);
            $table->index(['product_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_reservations');
    }
};
