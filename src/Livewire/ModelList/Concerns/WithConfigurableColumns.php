<?php

namespace BondarDe\Lox\Livewire\ModelList\Concerns;

use BondarDe\Lox\Livewire\ModelList\Data\ColumnConfiguration;

interface WithConfigurableColumns
{
    /**
     * @return array<string, ColumnConfiguration>
     */
    public static function getModelListColumnConfigurations(): array;
}
