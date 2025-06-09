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
            // Tambahkan kolom yang diperlukan
            $table->boolean('is_active')->default(true)->after('parent_id');
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->integer('sort_order')->default(0)->after('is_featured');
            $table->text('description')->nullable()->after('sort_order');
            $table->string('meta_title')->nullable()->after('description');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'is_featured',
                'sort_order',
                'description',
                'meta_title',
                'meta_description'
            ]);
        });
    }
};
