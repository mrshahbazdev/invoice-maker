<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:process-recurring-invoices')->daily();
Schedule::command('invoices:send-reminders')->daily();
Schedule::command('invoices:send-scheduled')->daily();
