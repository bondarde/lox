<?php

namespace BondarDe\Lox\Filament;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

trait HasModelCountNavigationBadge
{
    public static function getNavigationBadge(): ?string
    {
        /** @var Model $model */
        $model = static::getModel();
        $count = $model::count();

        return Number::format($count);
    }
}
