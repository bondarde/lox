<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Data;

class SystemCategory
{
    public function __construct(
        public readonly string $label,
        public readonly string $description,
        public readonly string $uri,
    )
    {
    }
}
