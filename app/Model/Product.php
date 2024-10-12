<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\ProductInterface;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\DbConnection\Model\Model;

class Product extends Model implements ProductInterface
{
    public bool $timestamps = false;

    protected ?string $table = 'products';

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
        // TODO: Implement getId() method.
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function getColor(): string
    {
        // TODO: Implement getColor() method.
    }

    public function getHeight(): string
    {
        // TODO: Implement getHeight() method.
    }

    public function getOriginalValue(): float
    {
        // TODO: Implement getOriginalValue() method.
    }
}
