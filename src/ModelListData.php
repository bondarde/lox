<?php

namespace BondarDe\Lox;

readonly class ModelListData
{
    public function __construct(
        public string  $model,
        public int     $activePage,
        public array   $allFilters,
        public array   $activeFilters,
        public array   $allSorts,
        public array   $activeSorts,
        public ?string $searchQuery = null,
    )
    {
    }
}
