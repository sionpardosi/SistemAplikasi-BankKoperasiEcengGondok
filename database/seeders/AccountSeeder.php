<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            // ── ASET ──────────────────────────────────────
            [
                'kode'         => '1-001',
                'nama'         => 'Kas',
                'tipe'         => 'aset',
                'saldo_normal' => 'debit',
            ],
            [
                'kode'         => '1-002',
                'nama'         => 'Piutang Usaha',
                'tipe'         => 'aset',
                'saldo_normal' => 'debit',
            ],
            [
                'kode'         => '1-003',
                'nama'         => 'Persediaan Bahan Baku',
                'tipe'         => 'aset',
                'saldo_normal' => 'debit',
            ],

            // ── LIABILITAS ────────────────────────────────
            [
                'kode'         => '2-001',
                'nama'         => 'Utang Usaha',
                'tipe'         => 'liabilitas',
                'saldo_normal' => 'kredit',
            ],

            // ── EKUITAS ───────────────────────────────────
            [
                'kode'         => '3-001',
                'nama'         => 'Modal Pemilik',
                'tipe'         => 'ekuitas',
                'saldo_normal' => 'kredit',
            ],
            [
                'kode'         => '3-002',
                'nama'         => 'Laba Ditahan',
                'tipe'         => 'ekuitas',
                'saldo_normal' => 'kredit',
            ],

            // ── PENDAPATAN ────────────────────────────────
            [
                'kode'         => '4-001',
                'nama'         => 'Pendapatan Penjualan Online',
                'tipe'         => 'pendapatan',
                'saldo_normal' => 'kredit',
            ],
            [
                'kode'         => '4-002',
                'nama'         => 'Pendapatan Penjualan Offline',
                'tipe'         => 'pendapatan',
                'saldo_normal' => 'kredit',
            ],

            // ── BEBAN ─────────────────────────────────────
            [
                'kode'         => '5-001',
                'nama'         => 'Beban Bahan Baku',
                'tipe'         => 'beban',
                'saldo_normal' => 'debit',
            ],
            [
                'kode'         => '5-002',
                'nama'         => 'Beban Operasional',
                'tipe'         => 'beban',
                'saldo_normal' => 'debit',
            ],
            [
                'kode'         => '5-003',
                'nama'         => 'Beban Lain-lain',
                'tipe'         => 'beban',
                'saldo_normal' => 'debit',
            ],
            [
                'kode'         => '5-004',
                'nama'         => 'Beban Gaji Karyawan',
                'tipe'         => 'beban',
                'saldo_normal' => 'debit',
            ],
        ];

        foreach ($accounts as $account) {
            Account::updateOrCreate(
                ['kode' => $account['kode']],
                $account
            );
        }

        $this->command->info('✅ AccountSeeder: ' . count($accounts) . ' akun berhasil dibuat.');
    }
}
