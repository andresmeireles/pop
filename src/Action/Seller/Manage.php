<?php

declare(strict_types=1);

namespace App\Action\Seller;

use App\Contracts\Repository\SellerRepositoryInterface;
use App\Contracts\Repository\UserRepositoryInterface;
use App\Entity\Seller;
use App\Exceptions\ApiException;

readonly class Manage
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private SellerRepositoryInterface $sellerRepository,
    ) {
    }

    public function add(string $name): Seller
    {
        $sellerExists = $this->sellerRepository->findBy(['name' => $name]);
        if (0 !== count($sellerExists)) {
            throw new ApiException('Seller already exists');
        }

        return $this->sellerRepository->create($name);
    }

    public function bindToUser(int $sellerId, int $userId): void
    {
        $seller = $this->sellerRepository->byId($sellerId);
        if (null === $seller) {
            throw new ApiException('seller not found or not exists: ' . $sellerId);
        }

        $user = $this->userRepository->byId($userId);
        if (null === $user) {
            throw new ApiException('user not found or not exists: ' . $userId);
        }

        $this->sellerRepository->bindToUser($seller, $user);
    }
}
