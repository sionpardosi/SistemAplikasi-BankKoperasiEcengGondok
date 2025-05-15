<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\JobList;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Kasir Toko',
                'description' => 'Melayani pelanggan, menerima pembayaran, dan mengelola stok barang.',
                'category' => 'Full-time',
                'salary' => 3000000,
                'salary_type' => 'Per Bulan',
                'duration' => '6 Bulan',
                'target' => 'Melakukan transaksi minimal 100 pelanggan per hari.',
                'location' => 'Jakarta',
                'status' => 'Dibuka'
            ],
            [
                'title' => 'Customer Service',
                'description' => 'Menangani keluhan pelanggan dan memberikan informasi produk.',
                'category' => 'Part-time',
                'salary' => 50000,
                'salary_type' => 'Per Jam',
                'duration' => '3 Bulan',
                'target' => 'Menangani minimal 50 pelanggan per hari.',
                'location' => 'Remote',
                'status' => 'Dibuka'
            ],
            [
                'title' => 'Desainer Grafis',
                'description' => 'Membuat desain poster, brosur, dan konten sosial media.',
                'category' => 'Freelance',
                'salary' => 2000000,
                'salary_type' => 'Proyek',
                'duration' => '2 Bulan',
                'target' => 'Membuat minimal 10 desain dalam 2 bulan.',
                'location' => 'Bali',
                'status' => 'Dibuka'
            ],
            [
                'title' => 'Admin Online Shop',
                'description' => 'Mengelola pesanan online dan membalas chat pelanggan.',
                'category' => 'Full-time',
                'salary' => 3500000,
                'salary_type' => 'Per Bulan',
                'duration' => '1 Tahun',
                'target' => 'Membalas minimal 200 chat pelanggan per hari.',
                'location' => 'Surabaya',
                'status' => 'Dibuka'
            ],
            [
                'title' => 'Kurir Pengiriman',
                'description' => 'Mengantarkan barang ke pelanggan dengan cepat dan aman.',
                'category' => 'Part-time',
                'salary' => 150000,
                'salary_type' => 'Per Hari',
                'duration' => '3 Bulan',
                'target' => 'Mengantarkan minimal 30 paket per hari.',
                'location' => 'Bandung',
                'status' => 'Dibuka'
            ],
        ];

        foreach ($data as $item) {
            JobList::create($item);
        }
    }
}
