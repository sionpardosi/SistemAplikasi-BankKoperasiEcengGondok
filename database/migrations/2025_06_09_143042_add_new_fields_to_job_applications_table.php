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
        Schema::table('job_applications', function (Blueprint $table) {
            // Menambah field baru yang diperlukan
            $table->string('name')->after('user_id');
            $table->string('email')->after('name');
            $table->string('whatsapp_number')->after('phone_number');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->after('whatsapp_number');
        });

        // Update field yang sudah ada untuk menjadi nullable
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('cv')->nullable()->change();
            $table->text('skills')->nullable()->change();
            $table->text('cover_letter')->nullable()->change();
            $table->string('expected_salary')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'whatsapp_number', 'gender']);
            $table->string('cv')->nullable(false)->change();
            $table->text('skills')->nullable(false)->change();
            $table->text('cover_letter')->nullable(false)->change();
            $table->string('expected_salary')->nullable(false)->change();
        });
    }
};
