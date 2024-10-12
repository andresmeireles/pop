<?php

declare(strict_types=1);

namespace App\Action\Database;

use App\Contract\Database\ConditionInterface;

final readonly class Condition implements ConditionInterface
{
    private function __construct(private string $field, private string $value, private string $condition)
    {
    }

    public static function create(string $field, string $value, ?string $condition = null): self
    {
        return new self($field, $value, $condition ?? '=');
    }

    public function field(): string
    {
        return $this->field;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function condition(): string
    {
        return $this->condition;
    }

    public function toArray(): array
    {
        return [
            'field' => $this->field,
            'value' => $this->value,
            'condition' => $this->condition,
        ];
    }
}
