<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Repository\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    use Repository;
}