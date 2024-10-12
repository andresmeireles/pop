<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Model\UserInterface;
use App\Contract\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    use Repository;

    public function __construct(private readonly UserInterface $model)
    {
    }
}
