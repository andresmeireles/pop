<?php

declare(strict_types=1);

namespace App\Action\Database;

use App\Contract\Database\TransactionInterface;
use Hyperf\DbConnection\Db;

final class Transaction implements TransactionInterface
{
    public function beginTransaction(): void
    {
        Db::beginTransaction();
    }

    public function commit(): void
    {
        Db::commit();
    }

    public function rollback(): void
    {
        Db::rollback();
    }
}
