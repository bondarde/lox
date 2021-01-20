<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

use Illuminate\Database\Eloquent\Model;

class Matrix extends FormComponent
{
    public array $props;
    public array $options;
    public ?string $minValue;
    public ?string $maxValue;
    public ?Model $model;
    public bool $showPropLabel;
    public bool $strictCheck;

    public function __construct(
        array $fields,
        $options,
        ?string $minValue = '',
        ?string $maxValue = '',
        bool $showPropLabel = true,
        bool $strictCheck = false,
        ?Model $model = null
    )
    {
        $this->props = $fields;
        $this->options = self::toOptions($options);
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        $this->model = $model;
        $this->showPropLabel = $showPropLabel;
        $this->strictCheck = $strictCheck;
    }

    public function old($key)
    {
        $old = old($key);

        if ($old !== null) {
            return $old;
        }

        if (!$this->model) {
            return null;
        }

        return $this->model->{$key};
    }

    public function checked($key, $val): string
    {
        $old = $this->old($key);

        if ($old === null) {
            return '';
        }

        $isChecked = $this->strictCheck ? $old === $val : $old == $val;

        if (!$isChecked) {
            return '';
        }

        return 'checked="checked"';
    }

    public function render()
    {
        return view('laravel-toolbox::form.matrix');
    }
}
