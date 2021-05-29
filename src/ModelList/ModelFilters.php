<?php

namespace BondarDe\LaravelToolbox\ModelList;

abstract class ModelFilters
{
    const ALL = 'all';

    const DEFAULT_FILTER = self::ALL;

    public static function all(): array
    {
        return [
            self::ALL => new ModelFilter('alle', 'TRUE'),
        ];
    }
}
