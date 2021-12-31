<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DeleteAccountConfirmationController
{
    public function __invoke()
    {
        $confirmationString = Str::upper(Str::random(6));
        $confirmationHash = Crypt::encryptString($confirmationString);

        return view('profile.delete-account', compact(
            'confirmationString',
            'confirmationHash',
        ));
    }
}
