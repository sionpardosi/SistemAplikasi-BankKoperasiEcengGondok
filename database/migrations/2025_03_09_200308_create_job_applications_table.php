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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_lists')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('cv');
            $table->text('cover_letter');
            $table->string('phone_number');
            $table->string('education_level');
            $table->text('experience')->nullable();
            $table->string('expected_salary')->nullable();
            $table->text('skills');
            $table->text('additional_info')->nullable();
            $table->enum('status', ['Diterima', 'Ditolak', 'Diproses'])->default('Diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
