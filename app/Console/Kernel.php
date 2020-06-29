<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\SISTEM\BOTSIPD;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {


        $schedule->call(function () {
            BOTSIPD::listing(2021,4,true);
        })->everyFiveMinutes()->timezone('Asia/Jakarta');


        $schedule->call(function () {
            BOTSIPD::listing(2021,0,true);
        })->everyTenMinutes()->timezone('Asia/Jakarta');


        $schedule->call(function () {
            BOTSIPD::listing(2020,4,true);
        })->everyThirtyMinutes()->timezone('Asia/Jakarta');

        
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
