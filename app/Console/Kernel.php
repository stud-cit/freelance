<?php

namespace App\Console;

use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
                 $date = new DateTime($one->updated_at);

                 $proposal = DB::table('proposals')->where([['id_order', $one->id_order], ['id_worker', $one->id_worker]])->get()->first();

                 if (!is_null($one->time) || !is_null($proposal->time)) {
                     $time = explode(' ', is_null($proposal->time) ? $one->time : $proposal->time);
                     $time = $time[1] == 'год.' ? ceil($time[0] / 24) : $time[0];

                     $date->modify('+' . $time . ' day');

                     if ($date <= Carbon::now()) {
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
