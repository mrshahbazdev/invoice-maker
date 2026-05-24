<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:process-recurring-invoices')->hourly();
Schedule::command('invoices:send-reminders')->hourly();
Schedule::command('invoices:send-scheduled')->hourly();
Schedule::command('app:process-late-fees')->daily();
