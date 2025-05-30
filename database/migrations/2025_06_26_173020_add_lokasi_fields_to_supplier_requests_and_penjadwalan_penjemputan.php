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
        // Tambahkan ke tabel supplier_requests
        Schema::table('supplier_requests', function (Blueprint $table) {
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('detail_lokasi')->nullable();
        });

        // Tambahkan ke tabel penjadwalan_penjemputan
        Schema::table('penjadwalan_penjemputans', function (Blueprint $table) {
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('detail_lokasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_requests', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'desa', 'detail_lokasi']);
        });

        Schema::table('penjadwalan_penjemputan', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'desa', 'detail_lokasi']);
        });
    }
};
