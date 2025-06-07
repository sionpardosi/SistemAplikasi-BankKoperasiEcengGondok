<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_requests', function (Blueprint $table) {
            // Tambahkan kolom yang mungkin belum ada
            if (!Schema::hasColumn('supplier_requests', 'kecamatan')) {
                $table->string('kecamatan')->nullable()->after('lokasi');
            }

            if (!Schema::hasColumn('supplier_requests', 'desa')) {
                $table->string('desa')->nullable()->after('kecamatan');
            }

            if (!Schema::hasColumn('supplier_requests', 'detail_lokasi')) {
                $table->text('detail_lokasi')->nullable()->after('desa');
            }

            // Perbaiki nama kolom foreign key jika tidak sesuai
            if (Schema::hasColumn('supplier_requests', 'coupon_id') && !Schema::hasColumn('supplier_requests', 'kupon_id')) {
                $table->renameColumn('coupon_id', 'kupon_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('supplier_requests', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'desa', 'detail_lokasi']);
        });
    }
};
