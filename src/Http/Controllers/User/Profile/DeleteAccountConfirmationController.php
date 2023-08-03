<?php

namespace BondarDe\Lox\Http\Controllers\User\Profile;

use BondarDe\Lox\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DeleteAccountConfirmationController extends BaseController
{
    public function __invoke()
    {
        $confirmationString = Str::upper(Str::random(6));
        $confirmationHash = Crypt::encryptString($confirmationString);

        return self::viewWithFallback('profile.delete-account', compact(
            'confirmationString',
            'confirmationHash',
        ));
    }
}
