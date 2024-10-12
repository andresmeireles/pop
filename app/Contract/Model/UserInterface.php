<?php

declare(strict_types=1);

namespace App\Contract\Model;

interface UserInterface extends ModelInterface
{
    public function getName(): string;

    public function getEmail(): string;

    public function getPassword(): string;

    public function toArray(): array;
}
