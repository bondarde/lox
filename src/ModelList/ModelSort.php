<?php

namespace BondarDe\LaravelToolbox\ModelList;

class ModelSort
{
    public string $label;
    public string $title;
    public string $sql;

    public function __construct(string $label, string $sql, ?string $title = null)
    {
        $this->label = $label;
        $this->sql = $sql;
        $this->title = $title ?? $label;
    }
}
