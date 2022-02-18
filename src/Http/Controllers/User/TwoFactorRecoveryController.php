<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\User;

class TwoFactorRecoveryController
{
    public function __invoke()
    {
        $view = config('laravel-toolbox.views.two-factor-recovery');

        return view($view);
    }
}
