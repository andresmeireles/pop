<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Repository\ProductRepositoryInterface;
use App\Model\Product;

class ProductRepository implements ProductRepositoryInterface
{
    use Repository;

    private readonly Product $model;

    public function __construct()
    {
        $this->model = new Product();
    }
}
