<?php

namespace BondarDe\Lox\Livewire\ModelList\Columns;

use BondarDe\Lox\Livewire\ModelList\Data\ColumnConfiguration;
use BondarDe\Lox\Livewire\ModelList\Data\ModelBulkAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

abstract class ColumnConfigurations
{
    /**
     * @return array<string, ColumnConfiguration>
     */
    public static function all(): array
    {
        return [];
    }

    /**
     * @return array<ModelBulkAction>
     */
    public static function actions(): array
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

                return self::highlightSearchQuery($content, $q);
            },
        );
    }

    protected static function highlightSearchQuery(?string $content, ?string $q): string
    {
        if (! $content) {
            return '';
        }

        return Blade::render('<x-lox::search-highlighted-text :q="$q">{{ $content }}</x-lox::search-highlighted-text>', compact(
            'content',
            'q',
        ));
    }
}
