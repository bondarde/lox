<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User;

class TwoFactorRecoveryController
{
    public function __invoke()
    {
        return view('auth.two-factor-recovery');
    }
}
