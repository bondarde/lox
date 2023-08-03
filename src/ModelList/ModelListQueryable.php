<?php

namespace BondarDe\Lox\ModelList;

use Illuminate\Database\Eloquent\Builder;

interface ModelListQueryable
{
    public static function getModelListQuery(): Builder;
}
