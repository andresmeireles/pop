<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Model\ProductInterface;
use App\Contract\Repository\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    use Repository;

    public function __construct(private readonly ProductInterface $model)
    {
    }
}
