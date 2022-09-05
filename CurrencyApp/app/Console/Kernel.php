<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('adapter:daily TCMB')->dailyAt('15:31');#TCMB announce the new  rates every day ay 15:30 TRT
        $schedule->command('adapter:daily ECB')->dailyAt('15:16');#ECB announce the new  rates every day ay 14:15 CET(15:15 TRT)

        $schedule->command('adapter:daily TCMB')->everyMinute()->appendOutputTo('adapter.log');

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
