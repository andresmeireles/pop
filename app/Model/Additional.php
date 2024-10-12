<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\AdditionalInterface;
use App\Contract\Model\OrderInterface;
use Hyperf\Database\Model\Relations\BelongsTo;

class Additional extends Model implements AdditionalInterface
{
    public bool $timestamps = false;

    protected array $fillable = [
        'name',
        'value',
        'addition',
        'order_id',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getAddition(): bool
    {
        return $this->addition;
    }

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
