<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Model\OrderInterface;
use App\Contract\Repository\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    use Repository;

    public function __construct(private readonly OrderInterface $model)
    {
    }
}
