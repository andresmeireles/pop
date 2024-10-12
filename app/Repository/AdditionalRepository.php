<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Model\AdditionalInterface;
use App\Contract\Repository\AdditionalRepositoryInterface;

class AdditionalRepository implements AdditionalRepositoryInterface
{
    use Repository;

    public function __construct(private readonly AdditionalInterface $additional)
    {
    }
}
