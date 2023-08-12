<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System\Data;

readonly class SearchIndexStatus
{
    public function __construct(
        public string $className,
        public string $indexName,
        public array  $indexColumns,

        public int    $dbRowsCount,
        public int    $indexedRowsCount,
        public int    $delta,
    )
    {
    }
}
