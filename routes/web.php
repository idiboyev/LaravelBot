<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'app' => config('app.name'),
        'bot' => '@'.config('telegram.bots.savemix.username'),
        'webhook' => url('/api/telegram/webhook'),
    ]);
});
