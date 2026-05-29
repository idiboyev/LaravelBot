<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('telegram:yordam', function () {
    $this->info('@SaveMixBot — webhook buyruqlari:');
    $this->line('  php artisan savemix:webhook set');
    $this->line('  php artisan savemix:webhook info');
    $this->line('  php artisan savemix:webhook remove');
    $this->newLine();
    $this->comment('SDK varianti (set/info emas, flag ishlating):');
    $this->line('  php artisan telegram:webhook --setup');
    $this->line('  php artisan telegram:webhook --info');
})->purpose('Telegram webhook buyruqlariga yordam');
