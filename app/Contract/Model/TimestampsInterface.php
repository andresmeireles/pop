<?php

declare(strict_types=1);

namespace App\Contract\Model;

use DateTimeInterface;

interface TimestampsInterface
{
    public function getCreatedAt(): DateTimeInterface;

    public function getUpdatedAt(): DateTimeInterface;
}
