<?php

namespace App\Console;

use App\Jobs\InitializeUsersJob;
use App\Jobs\ProtectUserLogoutLogs;
use App\Jobs\SystemControlonTaskStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->job(new ProtectUserLogoutLogs)->everyThirtyMinutes();
        $schedule->job(new SystemControlonTaskStatus)->hourly();

        // 1 Time Job

        $schedule->job(new InitializeUsersJob);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
