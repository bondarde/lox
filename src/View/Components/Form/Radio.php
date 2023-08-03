<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Database\Eloquent\Model;

class Radio extends Choice
{
    public function __construct(
        string $name,
        $options,
        string $filter = '*',
        string $label = '',
        bool $isList = false,
        string $containerClass = '',
        int $display = self::DISPLAY_BLOCK,
        ?Model $model = null,
        bool $showErrors = false,
        $value = null
    )
    {
        parent::__construct(
            $label,
            $name,
            self::toOptions($options, $filter),
            $isList,
            $containerClass,
            self::TYPE_RADIO,
            $display,
            $model,
            $showErrors,
            $value
        );
    }
}
