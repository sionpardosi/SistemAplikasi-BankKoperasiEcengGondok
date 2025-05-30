<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pending_order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pending_order_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->decimal('price', 15, 2);
            $table->integer('quantity')->unsigned();
            $table->json('options')->nullable();

            $table->timestamps();

            $table->foreign('pending_order_id')->references('id')->on('pending_orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_order_items');
    }
};
