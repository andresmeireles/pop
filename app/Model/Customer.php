<?php

declare(strict_types=1);

namespace App\Model;

use App\Contract\Model\CustomerInterface;

class Customer extends Model implements CustomerInterface
{
    public bool $timestamps = false;

    protected array $fillable = [
        'company_name',
        'trade_name',
        'cnpj',
        'city',
        'state',
        'email',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getCompanyName(): string
    {
        return $this->company_name;
    }

    public function getTradeName(): string
    {
        return $this->trade_name;
    }

    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
