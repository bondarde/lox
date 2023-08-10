<?php

namespace BondarDe\Lox\Livewire\ModelList\Concerns;

use BondarDe\Lox\Livewire\ModelList\Columns\ColumnConfigurations;

interface WithConfigurableColumns
{
    /**
     * @return ?string class returning {@link ColumnConfigurations}
     */
    public static function getModelListColumnConfigurations(): ?string;
}
