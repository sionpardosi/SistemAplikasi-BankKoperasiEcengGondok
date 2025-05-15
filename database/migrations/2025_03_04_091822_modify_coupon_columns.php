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
        Schema::table('coupons', function (Blueprint $table) {
            // Ubah kolom value dan cart_value menjadi decimal dengan presisi 15 dan skala 2
            $table->decimal('value', 15, 2)->change();
            $table->decimal('cart_value', 15, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // Kembalikan ke default misalnya decimal(8,2)
            $table->decimal('value', 8, 2)->change();
            $table->decimal('cart_value', 8, 2)->change();
        });
    }

};
