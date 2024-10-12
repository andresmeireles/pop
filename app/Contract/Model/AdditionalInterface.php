<?php

declare(strict_types=1);

namespace App\Contract\Model;

interface AdditionalInterface extends ModelInterface
{
    public function getName(): string;

    public function getValue(): float;

    public function getAddition(): bool;

    public function getOrder(): OrderInterface;
}
