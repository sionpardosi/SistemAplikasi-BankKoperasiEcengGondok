<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('story')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->string('founder')->nullable();
            $table->date('established_date')->nullable();
            $table->text('address')->nullable();
            $table->text('contact_info')->nullable();
            $table->string('image1')->nullable();
            $table->string('image1_caption')->nullable();
            $table->string('image1_alt')->nullable();
            $table->string('image2')->nullable();
            $table->string('image2_caption')->nullable();
            $table->string('image2_alt')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
