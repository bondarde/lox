<?php

namespace BondarDe\Lox\ModelList;

use Closure;

class ModelFilter
{
    public function __construct(
        public readonly string         $label,
        public readonly string|Closure $query,
        public readonly ?string        $title = null,
    )
    {
    }
}
