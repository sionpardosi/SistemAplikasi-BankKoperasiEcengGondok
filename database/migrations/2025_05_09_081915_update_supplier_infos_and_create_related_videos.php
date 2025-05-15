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
        // Tambahkan kolom baru ke tabel supplier_infos
        Schema::table('supplier_infos', function (Blueprint $table) {
            $table->string('video_type')->nullable()->after('image');
            $table->string('video_url')->nullable()->after('video_type');
            $table->text('video_caption')->nullable()->after('video_url');
            $table->string('video_thumbnail')->nullable()->after('video_caption');
            $table->string('video_duration')->nullable()->after('video_thumbnail');
        });

        // Buat tabel related_videos
        Schema::create('related_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_type'); // 'local' or 'instagram'
            $table->string('video_url'); // For local: file path, For Instagram: full URL
            $table->string('thumbnail')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom dari tabel supplier_infos
        Schema::table('supplier_infos', function (Blueprint $table) {
            $table->dropColumn([
                'video_type',
                'video_url',
                'video_caption',
                'video_thumbnail',
                'video_duration',
            ]);
        });

        // Drop tabel related_videos
        Schema::dropIfExists('related_videos');
    }
};
