<?php

declare(strict_types=1);

namespace App\Contract\Model;

interface OrderProductInterface extends ModelInterface
{
    public function getOrder(): OrderInterface;

    public function getProduct(): ProductInterface;

    public function getAmount(): float;

    public function getQuantity(): int;
}
