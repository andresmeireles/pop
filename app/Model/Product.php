<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\ProductInterface;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\DbConnection\Model\Model;

class Product extends Model implements ProductInterface
{
    public bool $timestamps = false;

    protected array $fillable = [
        'name',
        'color',
        'height',
        'original_value',
    ];

    protected array $casts = [];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function getOriginalValue(): float
    {
        return $this->original_value;
    }
}
