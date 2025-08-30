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
        // Send H-1 reminders at 9:00 AM daily
        $schedule->command('whatsapp:send-reminders --type=h1')
            ->dailyAt('09:00')
            ->appendOutputTo(storage_path('logs/whatsapp-reminders.log'));

        // Send H-0 reminders at 7:00 AM daily
        $schedule->command('whatsapp:send-reminders --type=h0')
            ->dailyAt('07:00')
            ->appendOutputTo(storage_path('logs/whatsapp-reminders.log'));
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
