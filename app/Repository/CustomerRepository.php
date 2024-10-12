<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Model\CustomerInterface;
use App\Contract\Repository\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    use Repository;

    public function __construct(private readonly CustomerInterface $model)
    {
    }
}
