<?php

namespace BondarDe\Lox\Http\Requests\Admin\Users;

use BondarDe\Lox\Constants\ValidationRules;
use BondarDe\Lox\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            User::FIELD_EMAIL => [
                ValidationRules::REQUIRED,
                ValidationRules::email(),
            ],

            User::FIELD_NAME => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
            ],

            User::ATTRIBUTE_ROLES => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_ARRAY,
            ],

            User::ATTRIBUTE_PERMISSIONS => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_ARRAY,
            ],
        ];
    }
}
