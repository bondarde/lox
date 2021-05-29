<?php

namespace BondarDe\LaravelToolbox\ModelList;

class ModelFilter
{
    public string $label;
    public string $title;
    public string $sql;

    public function __construct(string $label, string $sql, ?string $title = null)
    {
        $this->label = $label;
        $this->title = $title ?? $label;
        $this->sql = $sql;
    }
}
