<?php

namespace BondarDe\Lox\ModelList;

interface ModelListSortable
{
    /**
     * @return ?string class returning {@link ModelSorts}
     */
    public static function getModelListSorts(): ?string;
}
