<?php

namespace App\Logging;

use Carbon\Carbon;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;

class DailyLog
{
    public function __invoke(array $config)
    {
        $path = isset($config['dir']) ? config('services.log.path')."{$config['dir']}/" : config('services.log.path');
        $logPath = ensureDirectoryPath($path);
        $date = Carbon::now()->format('Y-m-d');
        $log = $logPath . "{$date}.log";

        $logger = new Logger('date-daily');
        $formatter = new LineFormatter(
            "[%datetime%] %level_name%: %message% %context% %extra%\n",
            "H:i:s",
            true,
            true
        );

        $handler = new StreamHandler($log, Logger::DEBUG);
        $handler->setFormatter($formatter);

        $logger->pushHandler($handler);
        $logger->setTimezone(new \DateTimeZone('Asia/Seoul'));

        return $logger;
    }
}
