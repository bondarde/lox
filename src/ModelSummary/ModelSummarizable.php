<?php

namespace BondarDe\Lox\ModelSummary;

interface ModelSummarizable
{
    public static function getModelSummaryAttributeNameFormatters(): array;

    public static function getModelSummaryAttributeValueFormatters(): array;
}
