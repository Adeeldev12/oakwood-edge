<?php

use Illuminate\Support\Facades\Schedule;

// use Illuminate\Foundation\Inspiring;
// use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

// // Schedule::command('trials:check')->daily();
// Schedule::command('app:check-trial-expirations')
//     ->everyMinute();


//     protected function schedule(Schedule $schedule): void
// {
//     $schedule->job(new CheckTrialExpirationsJob)->everyMinute();
// }



Schedule::command('app:check-trial-expirations')
    ->everyMinute();
