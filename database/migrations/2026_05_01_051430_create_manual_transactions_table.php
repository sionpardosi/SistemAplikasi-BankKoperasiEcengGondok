<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manual_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis', ['pendapatan', 'pengeluaran']);
            $table->text('deskripsi');
            $table->foreignId('account_id')
                  ->constrained('accounts')
                  ->onDelete('restrict');
            $table->decimal('jumlah', 15, 2);
            $table->boolean('jurnal_dibuat')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manual_transactions');
    }
};
