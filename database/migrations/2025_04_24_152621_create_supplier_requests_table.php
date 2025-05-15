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
        Schema::create('supplier_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp');
            $table->string('no_wa');
            $table->string('lokasi')->default('Samosir')->nullable();
            $table->float('estimasi_kg');
            $table->enum('insentif', ['diskon', 'uang_tunai']);
            $table->string('foto'); // path ke folder storage
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            // relasi ke kupon (jika tabelnya sudah ada)
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_requests');
    }
};
