<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use App\Models\User;
use BondarDe\LaravelToolbox\Http\Requests\User\Profile\PasswordUpdateRequest;
use Illuminate\Support\Facades\Hash;

class UserPasswordUpdateController
{
    public function __invoke(PasswordUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        $newPassword = $data['new_password'];

        $user->forceFill([
            User::FIELD_PASSWORD => Hash::make($newPassword),
        ])->save();

        return redirect(route('profile.show'))
            ->with('success-message', __('Password updated'));
    }
}
