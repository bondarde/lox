<?php

namespace BondarDe\Lox\ModelList;

interface ModelListFilterable
{
    /**
     * @return ?string class returning {@link ModelFilters}
     */
    public static function getModelListFilters(): ?string;
}
