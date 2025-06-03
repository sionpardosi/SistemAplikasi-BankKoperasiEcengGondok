<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Migration ini opsional, hanya jika Anda ingin menambahkan field baru
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Field untuk soft delete manual (alternatif dari Laravel SoftDeletes)
            $table->boolean('is_active')->default(true)->after('featured');

            // Field untuk SEO (opsional)
            $table->string('meta_title')->nullable()->after('description');
            $table->text('meta_description')->nullable()->after('meta_title');

            // Field untuk tracking
            $table->unsignedInteger('view_count')->default(0)->after('quantity');
            $table->unsignedInteger('sold_count')->default(0)->after('view_count');

            // Field untuk status tambahan
            $table->enum('status', ['draft', 'published', 'archived'])->default('published')->after('is_active');

            // Field untuk dimensi produk (opsional untuk toko fisik)
            $table->decimal('weight', 8, 2)->nullable()->after('images');
            $table->string('dimensions')->nullable()->after('weight'); // format: "L x W x H"

            // Field untuk handling fee dan shipping
            $table->decimal('handling_fee', 10, 2)->default(0)->after('sale_price');
            $table->boolean('free_shipping')->default(false)->after('handling_fee');

            // Index untuk performa query
            $table->index(['is_active', 'status']);
            $table->index(['featured', 'is_active']);
            $table->index(['stock_status', 'quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'meta_title',
                'meta_description',
                'view_count',
                'sold_count',
                'status',
                'weight',
                'dimensions',
                'handling_fee',
                'free_shipping'
            ]);
        });
    }
};
