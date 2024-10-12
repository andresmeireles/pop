<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Repository\OrderProductRepositoryInterface;

class OrderProductRepository implements OrderProductRepositoryInterface
{
    use Repository;
}
