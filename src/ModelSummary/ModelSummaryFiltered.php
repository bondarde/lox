<?php

namespace BondarDe\LaravelToolbox\ModelSummary;

interface ModelSummaryFiltered
{
    public static function getModelSummaryVisibleAttributes(): ?array;

    public static function getModelSummaryHiddenAttributes(): ?array;
}
