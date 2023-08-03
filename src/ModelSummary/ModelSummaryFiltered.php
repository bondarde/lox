<?php

namespace BondarDe\Lox\ModelSummary;

interface ModelSummaryFiltered
{
    public static function getModelSummaryVisibleAttributes(): ?array;

    public static function getModelSummaryHiddenAttributes(): ?array;
}
