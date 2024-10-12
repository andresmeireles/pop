<?php

declare(strict_types=1);

namespace App\Contract\Model;

interface SellerInterface extends ModelInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getUser(): UserInterface;

    /** @return array<int, OrderInterface> */
    public function getOrders(): array;
}
