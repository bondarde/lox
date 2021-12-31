<?php

namespace BondarDe\LaravelToolbox\Http\Requests\User\Profile;

use BondarDe\LaravelToolbox\Constants\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class AccountDeleteRequest extends FormRequest
{
    const INPUT_CONFIRMATION_STRING = 'confirmation_string';
    const INPUT_CONFIRMATION_HASH = 'confirmation_hash';

    public function rules(): array
    {
        return [
            self::INPUT_CONFIRMATION_STRING => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
            ],
            self::INPUT_CONFIRMATION_HASH => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
            ],
        ];
    }

    protected function passedValidation()
    {
        if (
            !$this->input(self::INPUT_CONFIRMATION_STRING)
            || !$this->input(self::INPUT_CONFIRMATION_HASH)
            || Crypt::decryptString($this->input(self::INPUT_CONFIRMATION_HASH)) !== $this->input(self::INPUT_CONFIRMATION_STRING)
        ) {
            throw ValidationException::withMessages([
                self::INPUT_CONFIRMATION_STRING => __('Invalid input'),
            ]);
        }
    }
}
