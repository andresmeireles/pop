<?php

declare(strict_types=1);

namespace App\Contract\Model;

interface OrderInterface extends ModelInterface, TimestampsInterface
{
    public function getCustomer(): CustomerInterface;

    public function getSeller(): SellerInterface;

    /** @return array<int, ProductInterface> */
    public function getProducts(): array;
}
