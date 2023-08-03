<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Contracts\View\View;

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

    public function render(): View
    {
        return view('lox::form.boolean');
    }
}
