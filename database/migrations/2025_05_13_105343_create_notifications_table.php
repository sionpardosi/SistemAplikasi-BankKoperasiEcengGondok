<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('idnotification'); 
            $table->text('pesan');
            $table->dateTime('waktu');
            $table->string('status', 250);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
