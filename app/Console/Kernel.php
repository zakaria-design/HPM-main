<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan command hapus foto lama setiap hari
        $schedule->command('hapus:foto-lama')->daily();
    }

    protected function commands(): void
    {
        // Mendaftarkan command
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
