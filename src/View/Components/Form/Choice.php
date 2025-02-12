<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ExpectedValues;

abstract class Choice extends FormComponent
{
    public const string TYPE_RADIO = 'radio';
    public const string TYPE_CHECKBOX = 'checkbox';

    public const int DISPLAY_BLOCK = 1;
    public const int DISPLAY_INLINE = 2;

    public string $containerClass;

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
        string $containerClass = '',
        string $type = self::TYPE_CHECKBOX,
        int $display = self::DISPLAY_BLOCK,
        ?Model $model = null,
        bool $showErrors = false,
        $value = null,
    ) {
        $this->isList = $isList;

        $this->options = $options;
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->display = $display;
        $this->old = self::toValue($value, $this->name, $model);
        $this->showErrors = $showErrors;
        $this->containerClass = $containerClass;
    }

    public function checked($value): string
    {
        $old = $this->old;

        if ($this->isList) {
            $isChecked = $old !== null && in_array($value, $old, true);
        } else {
            $isChecked = $old !== null && $value === $old;
        }

        if (! $isChecked) {
            return '';
        }

        return 'checked="checked"';
    }

    public function render(): View
    {
        return view('lox::components.form.choice');
    }
}
