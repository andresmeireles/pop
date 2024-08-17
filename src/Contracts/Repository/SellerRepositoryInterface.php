<?php

namespace App\Contracts\Repository;

use App\Entity\Seller;
use App\Entity\User;

interface SellerRepositoryInterface
{
    public function byId(mixed $id): ?Seller;

    /**
     * @return array<int, Seller>
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    public function create(string $name): Seller;

    public function bindToUser(Seller $seller, User $user): void;
}
