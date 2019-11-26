<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $today = now()->format('Y-m-d');

        $schedule->command('portal:process-file-sizes')->everyTenMinutes();
        $schedule->command('portal:calculate-quarter-grade')->everyThirtyMinutes();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('telescope:prune')->daily();
        $schedule->command('portal:update-school-calendar')->daily();
        $schedule->command("portal:remove-attendance-duplicates --start_date=$today --end_date=$today")->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
