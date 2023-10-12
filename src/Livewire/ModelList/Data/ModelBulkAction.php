<?php

namespace BondarDe\Lox\Livewire\ModelList\Data;

use Closure;

readonly class ModelBulkAction
{
    public function __construct(
        public string  $label,
        public Closure $action,
    )
    {
    }
}
