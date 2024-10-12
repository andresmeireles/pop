<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\PersonalAccessTokenInterface;
use App\Contract\Model\UserInterface;
use DateTime;
use Hyperf\Database\Model\Relations\HasOne;

class PersonalAccessToken extends Model implements PersonalAccessTokenInterface
{
    protected array $fillable = [
        'user_id',
        'jwt',
        'access_token',
        'expires_at',
    ];

    protected array $casts = [
        'expires_at' => 'datetime',
    ];

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getJwt(): string
    {
        return $this->jwt;
    }

    public function isExpired(): bool
    {
        return new DateTime() > $this->expires_at;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
