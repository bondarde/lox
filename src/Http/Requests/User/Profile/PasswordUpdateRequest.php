<?php

namespace BondarDe\Lox\Http\Requests\User\Profile;

use BondarDe\Lox\Constants\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Rules\Password;

class PasswordUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $user = $this->user();

        return [
            'current_password' => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
            ],
            'new_password' => self::passwordRules(),
        ];
    }

    protected function passedValidation()
    {
        $user = $this->user();
        $validator = $this->validator;

        if (
            !$this->input('current_password')
            || !Hash::check($this->input('current_password'), $user->password)
        ) {
            throw ValidationException::withMessages([
                'current_password' => __('The provided password does not match your current password.'),
            ]);
        }
    }

    private static function passwordRules(): array
    {
        return [
            'required',
            'string',
            new Password,
            'confirmed',
        ];
    }
}
