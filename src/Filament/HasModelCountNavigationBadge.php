<?php

namespace BondarDe\Lox\Filament;

use Exception;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

trait HasModelCountNavigationBadge
{
    protected static function isNavigationBadgeEnabled(): bool
    {
        return config('lox.filament.panels.admin.model_count_navigation_badge.enabled');
    }

    public static function getNavigationBadge(): ?string
    {
        if (! static::isNavigationBadgeEnabled()) {
            return null;
        }

        /** @var Model $model */
        $model = static::getModel();
        $query = $model::query();
        $tenant = Filament::getTenant();

        if ($tenant) {
            $relationshipName = Str::camel(class_basename($tenant));

            if (method_exists($model, $relationshipName)) {
                $query->whereBelongsTo($tenant);
            }
        }

        try {
            $count = $query->count();

            return Number::format($count);
        } catch (Exception) {
            //
        }

        return null;
    }
}
