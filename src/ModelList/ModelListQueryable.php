<?php

namespace BondarDe\LaravelToolbox\ModelList;

use Illuminate\Database\Eloquent\Builder;

interface ModelListQueryable
{
    public static function getModelListQuery(): Builder;
}
