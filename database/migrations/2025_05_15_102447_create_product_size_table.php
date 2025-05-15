<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizeTable extends Migration
{
    public function up()
    {
        Schema::create('product_size', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('size_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('stock')->default(0); // stok per ukuran (opsional)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_size');
    }
}
