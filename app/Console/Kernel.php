<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('expire:pending-transactions')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected $middlewareAliases = [
        // Middleware lain yang sudah ada
        'recaptcha' => \App\Http\Middleware\VerifyRecaptcha::class,
    ];

    protected $middleware = [
        // Middleware lain yang sudah ada
        \App\Http\Middleware\SecurityHeaders::class,
    ];
}
