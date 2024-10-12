<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Model\OrderProductInterface;
use App\Contract\Repository\OrderProductRepositoryInterface;

class OrderProductRepository implements OrderProductRepositoryInterface
{
    use Repository;

    public function __construct(private readonly OrderProductInterface $model)
    {
    }
}
