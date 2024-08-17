<?php

namespace App\Contracts\Repository;

use App\Entity\Customer;

interface CustomerRepositoryInterface
{
    public function byId(int $id): ?Customer;
}
