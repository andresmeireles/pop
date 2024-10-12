<?php

declare(strict_types=1);

namespace App\Contract\Model;

interface PersonalAccessTokenInterface extends ModelInterface
{
    public function getJwt(): string;

    public function getUser(): UserInterface;

    public function getAccessToken(): string;

    public function isExpired(): bool;
}
