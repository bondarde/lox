<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;

class FormRow extends FormComponent
{
    public string $label;
    public ?string $for;
    public string $info;
    public string $description;
    public bool $showErrors;

    public string $labelProps;

    public function __construct(
        string $for = null,
        string $label = '',
        string $info = '',
        string $description = '',
        bool $showErrors = true
    )
    {
        if ($showErrors && !$for) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new IllegalStateException('Input name ("for" attribute) is required if errors are enabled.');
        }

        $this->label = $label;
        $this->for = $for;
        $this->info = $info;
        $this->description = $description;
        $this->showErrors = $showErrors;

        $this->labelProps = $this->makeLabelProps();
    }

    public function makeLabelProps(): string
    {
        if (!$this->for) {
            return '';
        }

        return self::renderProps([
            'for' => 'form-input-' . $this->for,
        ]);
    }

    public function render()
    {
        return view('laravel-toolbox::form.form-row');
    }
}
