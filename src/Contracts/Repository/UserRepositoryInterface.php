<?php

namespace App\Contracts\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function byId(int $id): ?User;
}
