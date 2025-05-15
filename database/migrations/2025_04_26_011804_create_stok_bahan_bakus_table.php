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
        Schema::create('stok_bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->float('jumlah_kg');
            $table->string('sumber')->nullable(); // Misalnya: Request, Manual, dll.
            $table->unsignedBigInteger('request_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('supplier_requests')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_bahan_bakus');
    }
};
