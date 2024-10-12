<?php

declare(strict_types=1);

namespace App\Contract\Error;

enum AuthenticationError implements AppErrorInterface
{
    case CredentialsNotMatch;

    public function getMessage(): string
    {
        return match ($this) {
            self::CredentialsNotMatch => 'email or password not match',
        };
    }
}
