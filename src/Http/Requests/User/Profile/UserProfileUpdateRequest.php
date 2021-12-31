<?php

namespace BondarDe\LaravelToolbox\Http\Requests\User\Profile;

use App\Models\User;
use BondarDe\LaravelToolbox\Constants\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UserProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $user = $this->user();

        return [
            User::FIELD_NAME => [
                ValidationRules::REQUIRED,
            ],
            User::FIELD_EMAIL => [
                ValidationRules::REQUIRED,
                ValidationRules::unique('users', 'email', $user->id),
            ],
        ];
    }
}
