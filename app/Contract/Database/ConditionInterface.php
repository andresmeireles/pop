<?php

declare(strict_types=1);

namespace App\Contract\Database;

interface ConditionInterface
{
    public function field(): string;

    public function value(): int|string;

    public function condition(): ?string;

    /** @return array{field: string, value: int|string, condition?: string} */
    public function toArray(): array;
}
