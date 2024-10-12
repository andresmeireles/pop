<?php

declare(strict_types=1);

namespace App\Contract\Bridge;

interface AppLoggerInterface
{
    /**
     * @param string $message
     * @param array $context
     */
    public function error(string $message, array $context = []): void;
}
