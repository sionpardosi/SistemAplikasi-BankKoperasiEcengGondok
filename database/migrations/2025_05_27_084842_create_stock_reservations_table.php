<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('pending_order_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index(['product_id', 'expires_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_reservations');
    }
};
