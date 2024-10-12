<?php

declare(strict_types=1);

namespace App\Contract\Model;

interface ProductInterface extends ModelInterface
{
    public function getName(): string;

    public function getColor(): string;

    public function getHeight(): string;

    public function getOriginalValue(): float;
}
