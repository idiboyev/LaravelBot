<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhookCommand extends Command
{
    protected $signature = 'telegram:webhook
                            {action : set, remove, yoki info}
                            {--url= : Webhook URL (set uchun, default: TELEGRAM_WEBHOOK_URL)}';

    protected $description = 'Telegram bot webhook ni boshqarish';

    public function handle(): int
    {
        $action = $this->argument('action');

        return match ($action) {
            'set' => $this->setWebhook(),
            'remove' => $this->removeWebhook(),
            'info' => $this->webhookInfo(),
            default => $this->invalidAction($action),
        };
    }

    private function setWebhook(): int
    {
        $url = $this->option('url') ?: config('telegram.bots.savemix.webhook_url');

        if (empty($url)) {
            $this->error('Webhook URL ko\'rsatilmagan. .env da TELEGRAM_WEBHOOK_URL ni to\'ldiring yoki --url=... bering.');

            return self::FAILURE;
        }

        $response = Telegram::setWebhook(['url' => $url]);

        if ($response) {
            $this->info("Webhook o'rnatildi: {$url}");
        } else {
            $this->error('Webhook o\'rnatilmadi.');
        }

        return $response ? self::SUCCESS : self::FAILURE;
    }

    private function removeWebhook(): int
    {
        $response = Telegram::removeWebhook();

        if ($response) {
            $this->info('Webhook o\'chirildi.');
        } else {
            $this->error('Webhook o\'chirilmadi.');
        }

        return $response ? self::SUCCESS : self::FAILURE;
    }

    private function webhookInfo(): int
    {
        $info = Telegram::getWebhookInfo();

        $this->line(json_encode($info->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return self::SUCCESS;
    }

    private function invalidAction(string $action): int
    {
        $this->error("Noto'g'ri action: {$action}. Qabul qilinadi: set, remove, info");

        return self::FAILURE;
    }
}
