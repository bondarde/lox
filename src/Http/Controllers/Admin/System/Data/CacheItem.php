<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Data;

use Carbon\Carbon;

class CacheItem
{
    public function __construct(
        public readonly string $filename,
        public readonly string $filepath,
        public readonly string $raw,
        public readonly mixed  $value,
        public readonly Carbon $expiresAt,
    )
    {
    }
}
