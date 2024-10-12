<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\SellerInterface;
use App\Contract\Model\UserInterface;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Database\Model\Relations\HasOne;

class Seller extends Model implements SellerInterface
{
    public bool $timestamps = false;

    /** @var array<int, string> */
    protected array $fillable = [
        'name',
        'user_id',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getOrders(): array
    {
        $orders = $this->orders;

        return iterator_to_array($orders);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'seller_id', 'id');
    }
}
