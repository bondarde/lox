<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

class Boolean extends FormComponent
{
    public string $name;
    public bool $showErrors;
    public string $label;
    private bool $isChecked;

    public function __construct(
        string $name,
        ?bool  $checked = null,
        object $model = null,
        string $label = '',
        bool   $showErrors = false
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->showErrors = $showErrors;

        $this->isChecked =
            ($checked !== null)
                ? $checked
                : (old($name) ?? (optional($model)->{$name} ?? false));
    }

    public function checked(): string
    {
        if (!$this->isChecked) {
            return '';
        }

        return 'checked="checked"';
    }

    public function render()
    {
        return view('laravel-toolbox::form.boolean');
    }
}
