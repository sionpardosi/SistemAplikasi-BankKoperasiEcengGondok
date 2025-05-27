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
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('tax', 15, 2);
            $table->decimal('total', 15, 2);
            $table->decimal('ongkir', 15, 2)->default(0);
            $table->string('kurir', 50)->nullable();

            // Alamat
            $table->string('name');
            $table->string('phone', 20);
            $table->string('locality');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('Indonesia');
            $table->string('landmark')->nullable();
            $table->string('zip', 10);

            // Status & waktu
            $table->enum('status', ['pending_payment', 'expired', 'converted'])->default('pending_payment');
            $table->timestamp('expires_at');
            $table->unsignedBigInteger('converted_to_order_id')->nullable();

            $table->timestamps();

            $table->index('expires_at');
            $table->index('status');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_orders');
    }
};
