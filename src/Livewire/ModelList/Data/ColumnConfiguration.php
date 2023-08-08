<?php

namespace BondarDe\Lox\Livewire\ModelList\Data;

use Closure;
use Illuminate\Support\Str;

readonly class ColumnConfiguration
{
    public function __construct(
        public ?string  $label = null,
        public ?Closure $render = null,
    )
    {
    }

    public static function toLabel(string $attribute): string
    {
        return Str::of($attribute)
            ->explode('_')
            ->map(fn(string $part) => Str::ucfirst($part))
            ->join(' ');
    }
}
