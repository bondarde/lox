<?php

namespace BondarDe\Lox\ModelList;

interface ModelListFilterable
{
    public static function getModelListFilters(): ?string;
}
