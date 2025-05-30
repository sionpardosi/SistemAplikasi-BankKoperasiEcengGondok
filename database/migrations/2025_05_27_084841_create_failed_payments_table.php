<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('failed_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pending_order_id')->constrained()->onDelete('cascade');
            $table->string('midtrans_order_id');
            $table->text('failure_reason')->nullable();
            $table->timestamp('failed_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('failed_payments');
    }
};
