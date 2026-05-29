<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhookController extends Controller
{
    public function __invoke(): Response
    {
        Telegram::bot(config('telegram.default', 'savemix'))->commandsHandler(true);

        return response('ok', 200);
    }
}
