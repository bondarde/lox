<?php

namespace BondarDe\LaravelToolbox\Database;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @template T
 */
abstract class ModelRepository
{
    /**
     * @return T
     */
    abstract public function model(): string;

    public function query(
        array|Closure|null $filter = null,
    ): Builder
    {
        $q = $this->model()::query();

        if ($filter instanceof Closure) {
            $filter($q);
        } else if (is_array($filter)) {
            $q->where($filter);
        }

        return $q;
    }

    public function count(
        array|Closure|null $filter = null,
    ): int
    {
        return $this->query($filter)->count();
    }

    /**
     * @return Collection<T>
     */
    public function all(): Collection
    {
        return $this->query()->get();
    }

    /**
     * @return T
     */
    public function new(array $attributes): Model
    {
        return $this->query()
            ->newModelInstance($attributes);
    }

    /**
     * @return T
     */
    public function create(array $attributes): Model
    {
        return $this->query()
            ->create($attributes);
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

    public function random(
        int                $limit = 1,
        array|Closure|null $filter = null,
    ): Collection
    {
        return $this->query($filter)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function update(
        Model|int|string $model,
        array            $attributes,
        array            $options = [],
    ): bool
    {
        if (gettype($model) === 'integer' || gettype($model) === 'string') {
            $model = $this->get($model);
        }

        return $model->update($attributes, $options);
    }

    public function delete(
        Model|int|string $model,
        bool             $forceDelete = false,
    ): bool
    {
        if (gettype($model) === 'integer' || gettype($model) === 'string') {
            $model = $this->get($model);
        }

        if ($forceDelete && in_array(SoftDeletes::class, class_uses_recursive($this->modelName()))) {
            return $model->forceDelete();
        }

        return $model->delete();
    }
}
