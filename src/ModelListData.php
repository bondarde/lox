<?php

namespace BondarDe\Lox;

class ModelListData
{
    public string $model;
    public int $activePage;
    public array $allFilters;
    public array $activeFilters;
    public array $allSorts;
    public array $activeSorts;
    public ?string $searchQuery;

    public function __construct(
        string  $model,
        int     $activePage,
        array   $allFilters,
        array   $activeFilters,
        array   $allSorts,
        array   $activeSorts,
        ?string $searchQuery
    )
    {
        $this->model = $model;
        $this->activePage = $activePage;
        $this->allFilters = $allFilters;
        $this->activeFilters = $activeFilters;
        $this->allSorts = $allSorts;
        $this->activeSorts = $activeSorts;
        $this->searchQuery = $searchQuery;
    }
}
