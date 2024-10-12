<?php

declare(strict_types=1);

namespace App\Bridge;

use App\Contract\Bridge\AppLoggerInterface;
use Psr\Log\LoggerInterface;

readonly class AppLogger implements AppLoggerInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function error(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }
}
