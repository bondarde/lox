<?php

namespace BondarDe\LaravelToolbox\ModelSummary;

interface ModelSummarizable
{
    public static function getModelSummaryAttributeNameFormatters(): array;

    public static function getModelSummaryAttributeValueFormatters(): array;
}
