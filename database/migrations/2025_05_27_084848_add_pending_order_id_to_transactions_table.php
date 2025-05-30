<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('pending_order_id')->unsigned()->nullable()->after('order_id');
            $table->foreign('pending_order_id')->references('id')->on('pending_orders')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['pending_order_id']);
            $table->dropColumn('pending_order_id');
        });
    }
};
