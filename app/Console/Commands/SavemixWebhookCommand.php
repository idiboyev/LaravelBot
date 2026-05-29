<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SavemixWebhookCommand extends Command
{
    protected $signature = 'savemix:webhook
                            {action=info : set, remove yoki info}
                            {--url= : Webhook URL (set uchun)}';

    protected $description = '@SaveMixBot webhook boshqaruvi (o\'zbek buyruq)';

    public function handle(): int
    {
        $bot = config('telegram.default', 'savemix');

        if (empty(config("telegram.bots.{$bot}.token"))) {
            $this->error("TELEGRAM_BOT_TOKEN .env da to'ldirilmagan.");

            return self::FAILURE;
        }

        $telegram = Telegram::bot($bot);

        return match ($this->argument('action')) {
            'set' => $this->setWebhook($telegram, $bot),
            'remove' => $this->removeWebhook($telegram),
            'info' => $this->webhookInfo($telegram),
            default => $this->invalidAction(),
        };
    }

    private function setWebhook($telegram, string $bot): int
    {
        $url = $this->option('url') ?: config("telegram.bots.{$bot}.webhook_url");

        if (empty($url)) {
            $this->error("Webhook URL yo'q. .env: TELEGRAM_WEBHOOK_URL yoki --url=https://...");

            return self::FAILURE;
        }

        if (! str_starts_with($url, 'https://')) {
            $this->error("Webhook faqat HTTPS bo'lishi kerak: {$url}");

            return self::FAILURE;
        }

        if ($telegram->setWebhook(['url' => $url])) {
            $this->info("Webhook o'rnatildi: {$url}");

            return self::SUCCESS;
        }

        $this->error('Webhook o\'rnatilmadi.');

        return self::FAILURE;
    }

    private function removeWebhook($telegram): int
    {
        if ($telegram->removeWebhook()) {
            $this->info('Webhook o\'chirildi.');

            return self::SUCCESS;
        }

        $this->error('Webhook o\'chirilmadi.');

        return self::FAILURE;
    }

    private function webhookInfo($telegram): int
    {
        $info = $telegram->getWebhookInfo();
        $this->line(json_encode($info->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return self::SUCCESS;
    }

    private function invalidAction(): int
    {
        $this->error("Noto'g'ri action. Ishlatish: php artisan savemix:webhook set|remove|info");

        return self::FAILURE;
    }
}
