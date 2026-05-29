<?php

use Telegram\Bot\Commands\HelpCommand;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Bot Name
    |--------------------------------------------------------------------------
    */

    'default' => env('TELEGRAM_BOT_NAME', 'savemix'),

    /*
    |--------------------------------------------------------------------------
    | Telegram Bots
    |--------------------------------------------------------------------------
    */

    'bots' => [
        'savemix' => [
            'username' => env('TELEGRAM_BOT_USERNAME', 'SaveMixBot'),
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'certificate_path' => env('TELEGRAM_CERTIFICATE_PATH', ''),
            'webhook_url' => env('TELEGRAM_WEBHOOK_URL', ''),
            'commands' => [
                \App\Telegram\Commands\StartCommand::class,
            ],
        ],
    ],

    'async_requests' => env('TELEGRAM_ASYNC_REQUESTS', false),

    'http_client_handler' => null,

    'base_bot_url' => null,

    'resolve_command_dependencies' => true,

    'commands' => [
        HelpCommand::class,
    ],

    'command_groups' => [],

    'shared_commands' => [],

];
