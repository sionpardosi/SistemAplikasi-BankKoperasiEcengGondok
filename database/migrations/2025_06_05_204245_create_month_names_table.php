<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('month_names')) {
            Schema::create('month_names', function (Blueprint $table) {
                $table->id();
                $table->string('name', 20);
                $table->timestamps();
            });

            DB::table('month_names')->insert([
                ['id' => 1, 'name' => 'January'],
                ['id' => 2, 'name' => 'February'],
                ['id' => 3, 'name' => 'March'],
                ['id' => 4, 'name' => 'April'],
                ['id' => 5, 'name' => 'May'],
                ['id' => 6, 'name' => 'June'],
                ['id' => 7, 'name' => 'July'],
                ['id' => 8, 'name' => 'August'],
                ['id' => 9, 'name' => 'September'],
                ['id' => 10, 'name' => 'October'],
                ['id' => 11, 'name' => 'November'],
                ['id' => 12, 'name' => 'December'],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('month_names');
    }
};
