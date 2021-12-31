<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User\Profile;

class UserPasswordEditController
{
    public function __invoke()
    {
        return view('profile.update-password');
    }
}
