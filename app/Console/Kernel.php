<?php

namespace App\Console;

use App\Models\Setting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * Register the application's command schedule.
   */
  protected function schedule(Schedule $schedule)
  {
    $time = Setting::where('key', 'notification_time')->first()?->value;
    $schedule->command('app:send-telegram-daily-stock')->dailyAt($time);
  }

  /**
   * Register the commands for the application.
   */
  protected function commands()
  {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}