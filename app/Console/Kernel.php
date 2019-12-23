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
             $this->currency_check();
             $this->deadline_check();
             $this->update_dept();
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

    function update_dept()
    {
        try {
            $req_url = 'https://asu.sumdu.edu.ua/api/getDivisions?key=DmHLw4JWcDjY9yoCVsle0J2D4am3EPuh';
            $response_json = json_decode(file_get_contents($req_url));

            DB::table('departments')->delete();
            DB::table('dept_type')->delete();

            $values = [];
            $types = [];

            foreach ($response_json->result as $one) {
                $temp = [
                    'id_dept' => $one->ID_DIV,
                    'name' => $one->NAME_DIV,
                    'id_type' => $one->KOD_TYPE
                ];

                $type = [
                    'id_type' => $one->KOD_TYPE,
                    'type_name' => $one->NAME_TYPE
                ];

                array_push($values, $temp);

                if(!in_array($type, $types)) {
                    array_push($types, $type);
                }
            }

            DB::table('dept_type')->insert($types);
            DB::table('departments')->insert($values);

            $users = DB::table('users')
                    ->leftJoin('departments', 'users.id_dept', '=', 'departments.id_dept')
                    ->whereNull('departments.name')
                    ->update(['id' => null]);
        } catch (\Exception $e) {
        }
    }

    private function currency_check()
    {
        try {
            $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
            $response_json = file_get_contents($req_url);

            $fp = fopen('currency.json', 'w');
            fwrite($fp, $response_json);
            fclose($fp);
        } catch (Exception $e) {
        }
    }

    private function deadline_check()
    {
        $orders = DB::table('orders')->where('status', 'in progress')->get();

        foreach ($orders as $one) {
            try {
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
            } catch (\Exception $e) {
            }
        }
    }
}
