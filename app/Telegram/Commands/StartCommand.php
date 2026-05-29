<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';

    protected string $description = 'Botni boshlash';

    public function handle(): void
    {
        $username = config('telegram.bots.savemix.username', 'SaveMixBot');

        $this->replyWithMessage([
            'text' => "Salom! Men @{$username}.\n\nBuyruqlar ro'yxati uchun /help yozing.",
        ]);
    }
}
