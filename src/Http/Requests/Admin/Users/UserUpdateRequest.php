<?php

namespace BondarDe\LaravelToolbox\Http\Requests\Admin\Users;

use BondarDe\LaravelToolbox\Constants\ValidationRules;
use BondarDe\LaravelToolbox\Models\User;
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

            User::ATTRIBUTE_GROUPS => [
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
