<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

use Illuminate\Database\Eloquent\Model;

class Select extends FormComponent
{
    public string $label;
    public array $options;
    public string $name;
    public string $cssClasses;
    public bool $showErrors;
    public $old;

    public function __construct(
        string $name,
               $options,
        string $pattern = '*',
        string $label = '',
        string $containerClass = '',
        bool   $showErrors = false,
        ?Model $model = null
    )
    {
        $this->label = $label;
        $this->name = $name;
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->options = self::toOptions($options, $pattern);
        $this->old = self::toValue(null, $this->name, $model);
        $this->cssClasses = self::toCssClasses($containerClass, $this->name);
        $this->showErrors = $showErrors;
    }

    private static function toCssClasses(string $containerClass, string $name): string
    {
        $styles = self::hasErrors($name)
            ? self::CONTAINER_CLASS_ERROR
            : self::CONTAINER_CLASS_DEFAULT;

        $containerClass = $containerClass . ' ' . $styles;

        return trim($containerClass);
    }

    public function selected($value): string
    {
        $isSelected = $this->old !== null && $value == $this->old;

        if (!$isSelected) {
            return '';
        }

        return 'selected="selected"';
    }

    public function render()
    {
        return view('laravel-toolbox::form.select');
    }
}
