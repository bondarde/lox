<?php

namespace BondarDe\LaravelToolbox\View\Components\Form;

use Illuminate\Database\Eloquent\Model;

class Checkbox extends Choice
{
    public function __construct(
        string $name,
        $options,
        string $label = '',
        bool $isList = false,
        int $display = self::DISPLAY_BLOCK,
        ?Model $model = null,
        bool $showErrors = false,
        $value = null
    )
    {
        parent::__construct(
            $label,
            $name,
            self::toOptions($options),
            $isList,
            self::TYPE_CHECKBOX,
            $display,
            $model,
            $showErrors,
            $value
        );
    }
}
