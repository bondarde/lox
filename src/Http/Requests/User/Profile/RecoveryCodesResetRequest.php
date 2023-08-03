<?php

namespace BondarDe\Lox\Http\Requests\User\Profile;

use BondarDe\Lox\Constants\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class RecoveryCodesResetRequest extends FormRequest
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
