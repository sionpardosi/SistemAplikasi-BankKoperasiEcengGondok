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
            $table->decimal('value', 15, 2)->change();
            $table->decimal('cart_value', 15, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('value', 8, 2)->change();
            $table->decimal('cart_value', 8, 2)->change();
        });
    }

};
