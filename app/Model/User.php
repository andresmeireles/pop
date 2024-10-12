<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\UserInterface;

class User extends Model implements UserInterface
{
    public bool $timestamps = false;

    protected array $fillable = [
        'name',
        'email',
        'password',
    ];

    protected array $hidden = [
        'password',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
