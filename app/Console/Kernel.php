<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Figure;
use App\Notification;
use App\Sale;
use App\ActualNotification;

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
       $schedule->exec("python " . public_path(). "\images\\nipponyasan.py ");
       $schedule->exec("python " . public_path(). "\images\biginjapan.py ");
       $schedule->exec("python " . public_path(). "\images\amiami\amiami.py ");
       $schedule->call(function () {

            $notifications = Notification::all();
            $dailysales = Sale::where('created_at', date("Y-m-d"))->get();
            foreach ($dailysales as $dailysale) {
              foreach ($notifications as $notification){
                if ($dailysale->figure['character_id'] == $notification['character_id']){

                  $isnotification = ActualNotification::where('user_id', $notification['user_id'])->where('sale_id', $dailysale['id'])->get();
                  if (count($isnotification) == 0)
                    ActualNotification::create(array(
                      'user_id'=> $notification['user_id'],
                      'sale_id'=> $dailysale['id'],
                    ));
                }
              }
            }

        });

        // $schedule->command('inspire')
        //          ->hourly();
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
