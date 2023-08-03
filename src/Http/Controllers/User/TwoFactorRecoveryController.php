<?php

namespace BondarDe\Lox\Http\Controllers\User;

class TwoFactorRecoveryController
{
    public function __invoke()
    {
        $view = config('lox.views.two-factor-recovery');

        return view($view);
    }
}
