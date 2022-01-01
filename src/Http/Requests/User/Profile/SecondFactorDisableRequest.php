<?php

namespace BondarDe\LaravelToolbox\Http\Requests\User\Profile;

use BondarDe\LaravelToolbox\Constants\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class SecondFactorDisableRequest extends FormRequest
{
    const CONFIRMATION_CODE = 'code';

    public function rules(): array
    {
        return [
            self::CONFIRMATION_CODE => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
                ValidationRules::min(6),
                ValidationRules::max(6),
            ],
        ];
    }
}
