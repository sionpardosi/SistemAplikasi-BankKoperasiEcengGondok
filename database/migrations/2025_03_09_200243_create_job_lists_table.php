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
        Schema::create('job_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['Full-time', 'Part-time', 'Freelance']);
            $table->decimal('salary', 10, 2);
            $table->enum('salary_type', ['Per Jam', 'Per Hari', 'Per Bulan', 'Proyek']);
            $table->string('duration');
            $table->string('target')->nullable();
            $table->string('location');
            $table->string('image')->nullable();
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['Dibuka', 'Ditutup', 'Selesai'])->default('Dibuka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_lists');
    }
};
