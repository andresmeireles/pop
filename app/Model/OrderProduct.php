<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\OrderInterface;
use App\Contract\Model\OrderProductInterface;
use App\Contract\Model\ProductInterface;
use Hyperf\Database\Model\Relations\HasOne;

class OrderProduct extends Model implements OrderProductInterface
{
    public bool $timestamps = false;

    protected array $fillable = [
        'order_id',
        'product_id',
        'amount',
        'quantity',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
