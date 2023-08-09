<?php

namespace BondarDe\Lox\ModelList;

use Closure;

readonly class ModelFilter
{
    public function __construct(
        public string  $label,
        public Closure $query,
        public ?string $title = null,
    )
    {
    }
}
