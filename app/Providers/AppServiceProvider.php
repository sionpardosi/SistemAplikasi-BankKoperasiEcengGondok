<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // if(config('app.env') === 'local') {
        //     URL::forceScheme('https');
        //     URL::forceRootUrl('https://b931-180-251-4-145.ngrok-free.app'); // Sesuaikan dengan URL ngrok Anda
        // }

        // if (config('app.env') !== 'local') {
        //     URL::forceScheme('https');
        // }

        // Helper function untuk format Rupiah
        if (!function_exists('formatRupiah')) {
            function formatRupiah($amount)
            {
                if ($amount == 0 || $amount == null) {
                    return 'Rp 0';
                }

                return 'Rp ' . number_format($amount, 0, ',', '.');
            }
        }

        // Helper function untuk format Rupiah dengan singkatan (opsional)
        if (!function_exists('formatRupiahShort')) {
            function formatRupiahShort($amount)
            {
                if ($amount == 0 || $amount == null) {
                    return 'Rp 0';
                }

                if ($amount >= 1000000000) {
                    return 'Rp ' . number_format($amount / 1000000000, 1) . 'M';
                } elseif ($amount >= 1000000) {
                    return 'Rp ' . number_format($amount / 1000000, 1) . 'Jt';
                } elseif ($amount >= 1000) {
                    return 'Rp ' . number_format($amount / 1000, 1) . 'rb';
                }

                return 'Rp ' . number_format($amount, 0, ',', '.');
            }
        }

        // Mengambil semua kategori yang sudah diurutkan
        $footerCategories = Category::orderBy('name', 'ASC')->get()->take(5);

        // Membagikan ke semua view
        View::share('footerCategories', $footerCategories);
    }
}
