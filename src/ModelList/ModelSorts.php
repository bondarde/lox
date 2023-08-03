<?php

namespace BondarDe\Lox\ModelList;

abstract class ModelSorts
{
    const ID = 'id';
    const DEFAULT_SORT = self::ID;

    public static function all(): array
    {
        return [
            self::ID => new ModelSort('ID', 'id DESC'),
        ];
    }
}
