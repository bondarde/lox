<?php

namespace BondarDe\LaravelToolbox\Http\Requests\Admin\Users;

use BondarDe\LaravelToolbox\Constants\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserRoleUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                ValidationRules::REQUIRED,
                ValidationRules::min(1),
            ],
            'guard_name' => [
                ValidationRules::REQUIRED,
                Rule::in([
                    'web',
                    'api',
                ]),
            ],
            'permissions' => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_ARRAY,
            ],
        ];
    }
}
