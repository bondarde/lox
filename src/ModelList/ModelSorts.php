<?php

namespace BondarDe\Lox\ModelList;

use Illuminate\Database\Eloquent\Builder;

abstract class ModelSorts
{
    public static function all(): array
    {
        return [
            'id' => new ModelSort(
                'ID',
                fn(Builder $q, string $direction = 'desc') => $q->orderBy('id', $direction),
            ),
        ];
    }

    public static function default(): array
    {
        return [
            'id-',
        ];
    }
}
