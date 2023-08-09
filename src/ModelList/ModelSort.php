<?php

namespace BondarDe\Lox\ModelList;

class ModelSort
{
    public function __construct(
        public readonly string $label,
        public readonly string $sql,
        public ?string         $title = null,
    )
    {
        $this->title = $title ?? $label;
    }
}
