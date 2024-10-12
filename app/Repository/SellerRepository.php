<?php

declare(strict_types=1);

namespace App\Repository;

use App\Action\Database\Condition;
use App\Contract\Model\SellerInterface;
use App\Contract\Repository\SellerRepositoryInterface;

class SellerRepository implements SellerRepositoryInterface
{
    use Repository;

    public function __construct(private readonly SellerInterface $model)
    {
    }

    public function sellerByUserId(int $userId): ?SellerInterface
    {
        $models = $this->findBy(Condition::create('user_id', $userId));
        if (count($models) === 0) {
            return null;
        }

        return $models[0];
    }
}
