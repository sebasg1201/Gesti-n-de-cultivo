<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
// Artisan alias is already imported at the top

// Registering commands implicitly works in recent Laravel versions if in App\Console\Commands

Schedule::command('app:check-license-expiration')->daily();
