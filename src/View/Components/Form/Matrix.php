<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Contracts\View\View;
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
    public bool $showErrors;

    public function __construct(
        array   $fields,
                $options,
        string  $pattern = '*',
        ?string $minValue = '',
        ?string $maxValue = '',
        bool    $showPropLabel = true,
        bool    $strictCheck = false,
        bool    $showErrors = true,
        ?Model  $model = null
    )
    {
        $this->props = $fields;
        $this->options = self::toOptions($options, $pattern);
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        $this->model = $model;
        $this->showPropLabel = $showPropLabel;
        $this->strictCheck = $strictCheck;
        $this->showErrors = $showErrors;
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

    public function render(): View
    {
        return view('lox::form.matrix');
    }
}
