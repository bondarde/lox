<?php

namespace BondarDe\LaravelToolbox\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class RelativeTimestamp extends Component
{
    public Model $model;
    public string $attr;

    public function __construct(
        Model $model,
        string $attr
    )
    {
        $this->model = $model;
        $this->attr = $attr;
    }

    public function render()
    {
        return view('laravel-toolbox::relative-timestamp');
    }
}
