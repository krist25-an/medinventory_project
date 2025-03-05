<?php

use App\Models\Setting;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
  $time = Setting::where('key', 'notification_time')->value('value') ?? '08:00';
  $time = '18:35';
  if (now()->format('H:i') === $time) {
    Artisan::call('app:send-telegram-daily-stock');
  }
})->everyMinute();
