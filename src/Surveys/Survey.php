<?php

namespace BondarDe\LaravelToolbox\Surveys;

interface Survey
{
    public static function getId(): string;

    public static function getSteps(): array;
}
