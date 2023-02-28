<?php

namespace BondarDe\LaravelToolbox\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @template T
 */
abstract class ModelRepository
{
    /**
     * @return T
     */
    abstract public function model(): Model;

    private function query(): Builder
    {
        return $this->model()::query();
    }

    /**
     * @return Collection<T>
     */
    public function all(): Collection
    {
        return $this->query()->get();
    }

    /**
     * @param int|string $id
     * @return T
     * @throws
     */
    public function get(int|string $id): Model
    {
        return $this->query()
            ->whereKey($id)
            ->sole();
    }

    /**
     * @param int|string $id
     * @return T|null
     */
    public function find(int|string $id): ?Model
    {
        return $this->query()
            ->find($id);
    }
}
