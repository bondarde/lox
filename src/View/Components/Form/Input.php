<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Contracts\View\View;

class Input extends FormComponent
{
    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_DATE = 'date';

    public string $label;
    public string $name;
    public $value;
    public string $containerClass;
    public string $inputClass;
    public $type;
    public $step;
    public $min;
    public $max;
    public $prefix;
    public $suffix;
    public $placeholder;

    private bool $inputHasErrors;
    public bool $showErrors;

    public function __construct(
        string $name,
        string $label = '',
        string $containerClass = '',
        string $inputClass = '',
               $type = self::TYPE_TEXT,
               $step = 1,
               $min = null,
               $max = null,
               $placeholder = '',
               $prefix = '',
               $suffix = '',
               $model = null,
               $value = null,
        bool   $showErrors = false
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = self::toValue($value, $name, $model);
        $this->type = $type;
        $this->step = $step;
        $this->min = $min;
        $this->max = $max;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->placeholder = $placeholder;

        $this->inputHasErrors = self::hasErrors($this->name);

        if ($this->inputHasErrors) {
            $containerClass .= ' ' . self::CONTAINER_CLASS_ERROR;
        } else {
            $containerClass .= ' ' . self::CONTAINER_CLASS_DEFAULT;
        }

        $this->containerClass = trim($containerClass);
        $this->inputClass = $inputClass;
        $this->showErrors = $showErrors;
    }

    public function props(): string
    {
        $props = [];

        switch ($this->type) {
            case self::TYPE_NUMBER:
            case self::TYPE_DATE:
                $props['step'] = $this->step;
                if ($this->min !== null) {
                    $props['min'] = $this->min;
                }
                if ($this->max !== null) {
                    $props['max'] = $this->max;
                }
                break;
        }

        return self::renderProps($props);
    }

    public function render(): View
    {
        return view('lox::form.input');
    }
}
