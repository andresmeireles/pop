<?php

declare(strict_types=1);

namespace App\Contract\Error;

enum AuthenticationError implements AppErrorInterface
{
    case CredentialsNotMatch;
    case InvalidToken;
    
    case ExpiredToken;

    public function getMessage(): string
    {
        return match ($this) {
            self::CredentialsNotMatch => 'email or password not match',
            self::InvalidToken => 'invalid bearer token',
            self::ExpiredToken => 'token expired',
        };
    }
}
