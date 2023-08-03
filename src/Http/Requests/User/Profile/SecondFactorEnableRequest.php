<?php

namespace BondarDe\Lox\Http\Requests\User\Profile;

use BondarDe\Lox\Constants\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class SecondFactorEnableRequest extends FormRequest
{
    const SECRET_KEY = 'secret';
    const RECOVERY_CODES = 'recovery_codes';

    const CONFIRMATION_CODE = 'code';
    const RECOVERY_CODES_STORED = 'recovery_codes_stored';

    public function rules(): array
    {
        return [
            self::CONFIRMATION_CODE => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
                ValidationRules::min(6),
                ValidationRules::max(6),
            ],

            self::RECOVERY_CODES_STORED => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_BOOLEAN,
                'accepted',
            ],

            self::SECRET_KEY => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
            ],

            self::RECOVERY_CODES => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            self::RECOVERY_CODES_STORED => $this->boolean(self::RECOVERY_CODES_STORED),
        ]);
    }
}
