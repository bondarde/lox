<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ExpectedValues;

class Choice extends FormComponent
{
    public const TYPE_RADIO = 'radio';
    public const TYPE_CHECKBOX = 'checkbox';

    public const DISPLAY_BLOCK = 1;
    public const DISPLAY_INLINE = 2;

    #[ExpectedValues(values: [self::TYPE_RADIO, self::TYPE_CHECKBOX])]
    public string $type;

    #[ExpectedValues(values: [self::DISPLAY_BLOCK, self::DISPLAY_INLINE])]
    public int $display;

    public string $label;
    public string $name;
    public bool $isList;
    public array $options = [];

    public bool $showErrors;

    private $old;

    public function __construct(
        string $label,
        string $name,
        array $options,
        bool $isList = false,
        string $type = self::TYPE_CHECKBOX,
        int $display = self::DISPLAY_BLOCK,
        ?Model $model = null,
        bool $showErrors = false,
        $value = null
    )
    {
        $this->isList = $isList;

        $this->options = $options;
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->display = $display;
        $this->old = self::toValue($value, $this->name, $model);
        $this->showErrors = $showErrors;
    }

    public function checked($value): string
    {
        $old = $this->old;

        if ($this->isList) {
            $isChecked = $old !== null && in_array($value, $old);
        } else {
            $isChecked = $value === $old;
        }

        if (!$isChecked) {
            return '';
        }

        return 'checked="checked"';
    }

    public function render()
    {
        return view('laravel-toolbox::form.choice');
    }
}
