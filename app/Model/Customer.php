<?php

declare(strict_types=1);

namespace App\Model;

class Customer extends Model
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
}
