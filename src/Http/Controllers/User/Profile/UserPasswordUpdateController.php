<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use App\Models\User;
use BondarDe\Lox\Http\Requests\User\Profile\PasswordUpdateRequest;
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

        return redirect(route('user.index'))
            ->with('success-message', __('Password updated'));
    }
}
