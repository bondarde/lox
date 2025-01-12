<?php

namespace BondarDe\Lox\Constants\Cms;

enum CmsTemplateVariableType: int
{
    case Html = 100;
    case PlainText = 150;
    case Media = 200;

    public static function formOptions(): array
    {
        return collect(self::cases())
            ->pluck('name', 'value')
            ->toArray();
    }

    public function label(): string
    {
        return match ($this) {
            self::Html => __('html'),
            self::PlainText => __('text'),
            self::Media => __('media'),
        };
    }
}
