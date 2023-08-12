<?php

namespace BondarDe\Lox\ModelList;

use JetBrains\PhpStorm\Deprecated;

#[Deprecated]
interface ModelListSearchable
{
    public static function getModelListSearchFields(): ?array;
}
