<?php

declare(strict_types=1);

namespace App\Contract\Error;

enum CreateUserError implements AppErrorInterface
{
    case PasswordNotMatch;
    case UserAlreadyExists;

    public function getMessage(): string
    {
        return match ($this) {
            self::PasswordNotMatch => 'passwords not match',
            self::UserAlreadyExists => 'user already exists',
        };
    }
}
