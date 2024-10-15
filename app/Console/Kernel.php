<?php

namespace App\Console;

use App\Models\BackupSchedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $this->scheduleBackup($schedule);
        //$schedule->command('inspire')->everySecond();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }

    /**
     * Schedule the backup commands.
     */
    protected function scheduleBackup($schedule)
    {
        // Fetch the backup settings from the table
        $backupSettings = BackupSchedule::first();

        if ($backupSettings) {
            // Schedule the backup:clean and backup:run command 5 minutes before backup run
            if ($backupSettings->type == 'daily') {
                $schedule->command('backup:clean')->dailyAt(substr($backupSettings->time, 0, -3));
                $schedule->command('backup:run-and-store-path')->dailyAt(substr($backupSettings->time, 0, -3))->after(function () {
                    // This command will be scheduled to run after the 'backup:clean' command
                });
            } elseif ($backupSettings->type == 'weekly' && $backupSettings->day_of_week) {
                $schedule->command('backup:clean')->weeklyOn($backupSettings->day_of_week, substr($backupSettings->time, 0, -3));
                $schedule->command('backup:run-and-store-path')->weeklyOn($backupSettings->day_of_week, substr($backupSettings->time, 0, -3))->after(function () {
                    // This command will be scheduled to run after the 'backup:clean' command
                });
            } elseif ($backupSettings->type == 'monthly' && $backupSettings->day_of_month) {
                $dayOfMonth = date('j', strtotime($backupSettings->day_of_month));
                $schedule->command('backup:clean')->monthlyOn($dayOfMonth, substr($backupSettings->time, 0, -3));
                $schedule->command('backup:run-and-store-path')->monthlyOn($dayOfMonth, substr($backupSettings->time, 0, -3))->after(function () {
                    // This command will be scheduled to run after the 'backup:clean' command
                });
            }
        }
    }
}
