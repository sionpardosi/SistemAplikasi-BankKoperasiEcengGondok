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

        // Mengambil semua kategori yang sudah diurutkan
        $footerCategories = Category::orderBy('name', 'ASC')->get()->take(5);

        // Membagikan ke semua view
        View::share('footerCategories', $footerCategories);
    }
}
