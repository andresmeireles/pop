<?php

declare(strict_types=1);

namespace App\Contract\Error;

enum OrderError implements AppErrorInterface
{
    case CreateOrderError;

    public function getMessage(): string
    {
        return match ($this) {
            self::CreateOrderError => 'Error on order create'
        };
    }
}
