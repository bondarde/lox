<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class ModelMeta extends Component
{
    public ?Model $model;

    public function __construct(
        ?Model $model = null
    )
    {
        $this->model = $model;
    }

    public function render()
    {
        if (is_null($this->model)) {
            return '<div class="opacity-50 italic mb-8">null</div>';
        }

        return view('lox::model-meta');
    }
}
