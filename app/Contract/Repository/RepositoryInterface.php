<?php

declare(strict_types=1);

namespace App\Contract\Repository;

use App\Contract\Database\ConditionInterface;

/** @template T */
interface RepositoryInterface
{
    /** @return array<int, T> */
    public function all(): array;

    /** @return null|T */
    public function byId(int $id);

    /**
     * @return array<int, T>
     */
    public function findBy(ConditionInterface ...$condition): array;

    /**
     * @param array<string, string> $content
     * @return T
     */
    public function create(array $content);

    public function exists(ConditionInterface ...$condition): bool;
}
