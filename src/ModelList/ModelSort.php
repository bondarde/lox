<?php

namespace BondarDe\Lox\ModelList;

use Closure;

class ModelSort
{
    public function __construct(
        public readonly string  $label,
        public readonly Closure $sql,
        public ?string          $title = null,
    )
    {
        $this->title = $title ?? $label;
    }
}
