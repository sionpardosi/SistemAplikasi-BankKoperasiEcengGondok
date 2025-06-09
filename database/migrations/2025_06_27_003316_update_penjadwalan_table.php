<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('penjadwalan_penjemputans', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('penjadwalan_penjemputans', 'kecamatan')) {
                $table->string('kecamatan')->nullable()->after('lokasi');
            }

            if (!Schema::hasColumn('penjadwalan_penjemputans', 'desa')) {
                $table->string('desa')->nullable()->after('kecamatan');
            }

            if (!Schema::hasColumn('penjadwalan_penjemputans', 'detail_lokasi')) {
                $table->text('detail_lokasi')->nullable()->after('desa');
            }

            // Add indexes for better performance
            $table->index('status_jemput');
            $table->index('tanggal_jemput');
            $table->index(['kecamatan', 'desa']);
        });

        // Update existing records to populate new location fields from related supplier requests
        if (Schema::hasTable('penjadwalan_penjemputans') && Schema::hasTable('supplier_requests')) {
            DB::statement("
                UPDATE penjadwalan_penjemputans p
                JOIN supplier_requests s ON p.supplier_request_id = s.id
                SET
                    p.kecamatan = COALESCE(p.kecamatan, s.kecamatan),
                    p.desa = COALESCE(p.desa, s.desa),
                    p.detail_lokasi = COALESCE(p.detail_lokasi, s.detail_lokasi)
                WHERE p.kecamatan IS NULL OR p.desa IS NULL OR p.detail_lokasi IS NULL
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjadwalan_penjemputans', function (Blueprint $table) {
            // Remove indexes first
            $table->dropIndex(['status_jemput']);
            $table->dropIndex(['tanggal_jemput']);
            $table->dropIndex(['kecamatan', 'desa']);

            // Remove columns
            $table->dropColumn(['kecamatan', 'desa', 'detail_lokasi']);
        });
    }
};
