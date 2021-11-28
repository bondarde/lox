<?php

namespace BondarDe\LaravelToolbox;

class ModelListData
{
    public string $model;
    public int $activePage;
    public array $allFilters;
    public array $activeFilters;
    public array $allSorts;
    public array $activeSorts;

    public function __construct(
        string $model,
        int    $activePage,
        array  $allFilters,
        array  $activeFilters,
        array  $allSorts,
        array  $activeSorts
    )
    {
        $this->model = $model;
        $this->activePage = $activePage;
        $this->allFilters = $allFilters;
        $this->activeFilters = $activeFilters;
        $this->allSorts = $allSorts;
        $this->activeSorts = $activeSorts;
    }
}
