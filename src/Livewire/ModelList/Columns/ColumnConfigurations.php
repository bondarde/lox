<?php

namespace BondarDe\Lox\Livewire\ModelList\Columns;

use BondarDe\Lox\Livewire\ModelList\Data\ColumnConfiguration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

abstract class ColumnConfigurations
{
    public static function all(): array
    {
        return [];
    }

    public static function render(Model $model, string $column, ?string $searchQuery): string
    {
        $renderConfigs = self::all();
        $renderConfig = $renderConfigs[$column] ?? self::defaultRenderer($column);
        $renderer = $renderConfig->render;

        return $renderer($model, $searchQuery);
    }

    private static function defaultRenderer(string $column): ColumnConfiguration
    {
        return new ColumnConfiguration(
            label: $column,
            render: function (Model $model, ?string $q) use ($column): string {
                $content = $model->{$column};

                return Blade::render('<x-search-highlighted-text :q="$q">{{ $content }}</x-search-highlighted-text>', compact(
                    'content',
                    'q',
                ));
            }
        );
    }
}
