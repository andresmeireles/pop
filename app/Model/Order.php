<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\CustomerInterface;
use App\Contract\Model\OrderInterface;
use App\Contract\Model\ProductInterface;
use App\Contract\Model\SellerInterface;
use DateTimeInterface;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Database\Model\Relations\HasOne;

class Order extends Model implements OrderInterface
{
    protected array $fillable = [
        'customer_id',
        'seller_id',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id');
    }

    public function additionals(): HasMany
    {
        return $this->hasMany(Additional::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    public function getSeller(): SellerInterface
    {
        return $this->seller;
    }

    public function getProducts(): array
    {
        $products = $this->products;

        return array_map(fn (ProductInterface $p) => $p, $products);
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updated_at;
    }
}
