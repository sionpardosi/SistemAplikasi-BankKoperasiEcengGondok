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
        Schema::create('penjadwalan_penjemputans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_request_id');
            $table->date('tanggal_jemput');
            $table->string('lokasi')->nullable();
            $table->float('estimasi_kg');
            $table->enum('status_jemput', ['terjadwal', 'dijemput', 'dibatalkan'])->default('terjadwal');
            $table->timestamps();

            $table->foreign('supplier_request_id')->references('id')->on('supplier_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjadwalan_penjemputans');
    }
};
