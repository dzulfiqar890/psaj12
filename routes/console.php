<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes - Katalog Gitar
|--------------------------------------------------------------------------
|
| Definisi scheduler dan artisan commands.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
|
| Jalankan scheduler dengan: php artisan schedule:run
| Untuk production, tambahkan cron job:
| * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
|
*/

// Newsletter mingguan - setiap Senin jam 09:00
Schedule::command('newsletter:send-weekly')
    ->weekly()
    ->mondays()
    ->at('09:00')
    ->withoutOverlapping()
    ->runInBackground();
