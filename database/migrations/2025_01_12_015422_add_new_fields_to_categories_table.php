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
        Schema::table('categories', function (Blueprint $table) {
            // Tambah kolom-kolom baru untuk fitur yang diperbaiki
            $table->text('description')->nullable()->after('slug');
            $table->string('meta_title', 60)->nullable()->after('description');
            $table->integer('sort_order')->default(0)->after('meta_title');
            $table->boolean('is_featured')->default(false)->after('sort_order');

            // Index untuk performa query
            $table->index('sort_order');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['is_featured']);

            $table->dropColumn([
                'description',
                'meta_title',
                'sort_order',
                'is_featured'
            ]);
        });
    }
};
