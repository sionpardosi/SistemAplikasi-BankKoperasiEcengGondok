<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('tax', 15, 2);
            $table->decimal('total', 15, 2);
            $table->decimal('ongkir', 15, 2)->default(0);
            $table->string('kurir', 50)->nullable();

            // Alamat pengiriman
            $table->string('name');
            $table->string('phone');
            $table->string('locality');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('Indonesia');
            $table->string('landmark')->nullable();
            $table->string('zip');

            // Status dan waktu
            $table->enum('status', ['pending_payment', 'expired', 'converted'])->default('pending_payment');
            $table->timestamp('expires_at');
            $table->bigInteger('converted_to_order_id')->unsigned()->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('converted_to_order_id')->references('id')->on('orders')->onDelete('set null');
            $table->index(['expires_at']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_orders');
    }
};
