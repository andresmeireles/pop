<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Model\PersonalAccessTokenInterface;
use App\Contract\Repository\PersonalAccessTokenRepositoryInterface;

class PersonalAccessTokenRepository implements PersonalAccessTokenRepositoryInterface
{
    use Repository;

    public function __construct(private readonly PersonalAccessTokenInterface $model)
    {
    }
}
