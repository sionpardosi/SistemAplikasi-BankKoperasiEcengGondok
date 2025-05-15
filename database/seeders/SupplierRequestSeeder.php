<?php

namespace Database\Seeders;

use App\Models\SupplierRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupplierRequest::factory()->count(5)->create(); // asumsikan pakai factory
    }
}
