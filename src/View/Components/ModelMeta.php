<?php

namespace BondarDe\LaravelToolbox\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class ModelMeta extends Component
{
    public Model $model;

    public function __construct(
        Model $model
    )
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('laravel-toolbox::model-meta');
    }
}
