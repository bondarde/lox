<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Contracts\View\View;

class Textarea extends FormComponent
{
    public string $label;
    public string $name;
    public $value;
    public string $containerClass;
    public string $inputClass;

    private bool $inputHasErrors;
    public bool $showErrors;

    public function __construct(
        string $name,
        string $label = '',
        string $containerClass = '',
        string $inputClass = '',
               $model = null,
               $value = null,
        bool   $showErrors = false
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = self::toValue($value, $name, $model);

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

    public function render(): View
    {
        return view('lox::form.textarea');
    }
}
