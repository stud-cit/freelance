<?php

namespace App\Console;

use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

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
         $schedule->call(function() {
             $orders = DB::table('orders')->where('status', 'in progress')->get();

             foreach ($orders as $one) {
                 if (!is_null($one->time)) {
                     $time = explode(' ', $one->time);

                     $date = new DateTime($one->created_at);
                     $time = $time[1] == 'год.' ? ceil($time[0] / 24) : $time[0];

                     $date->modify('+' . $time . ' day');

                     if ($date >= Carbon::now()) {
                         $message = 'Час на виконання замовлення "' . $one->title . '" закінчився';

                         app('App\Http\Controllers\Controller')->send_email($one->id_worker, $message);
                     }
                 }
             }
         })->daily();
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
