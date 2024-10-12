<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Database\ConditionInterface;
use App\Model\Model;

/**
 * @property Model $model
 * @template T of Model
 */
trait Repository
{
    /**
     * @return null|T
     */
    public function byId(int $id)
    {
        return $this->model::find($id);
    }

    /** @return array<int, null|T> */
    public function all(): array
    {
        return $this->model::all()->toArray();
    }

    /**
     * @return T[]
     */
    public function findBy(ConditionInterface ...$condition): array
    {
        $model = $this->model;
        foreach ($condition as $value) {
            $model = $model->where($value->field(), $value->condition(), $value->value());
        }

        $return = [];
        foreach ($model->get() as $m) {
            $return[] = $m;
        }

        return $return;
    }

    /**
     * @param array<string, mixed> $content
     * @return T
     */
    public function create(array $content)
    {
        return $this->model::create($content);
    }

    public function exists(ConditionInterface ...$condition): bool
    {
        $models = $this->findBy(...$condition);

        return count($models) !== 0;
    }
}
