<?php

declare(strict_types=1);

namespace App\Contract\Database;

interface TransactionInterface
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}
