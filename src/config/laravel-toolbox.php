<?php

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;

$viewPrefix = LaravelToolboxServiceProvider::NAMESPACE . '::';

return [
    'page' => [
        'height' => env('LARAVEL_TOOLBOX_PAGE_HEIGHT'),
        'background' => env('LARAVEL_TOOLBOX_PAGE_BACKGROUND'),
        'text' => env('LARAVEL_TOOLBOX_PAGE_TEXT'),
    ],

    'views' => [
        'profile' => [
            'index' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_LOGIN', $viewPrefix . 'profile.index'),
        ],
        'auth' => [
            'register' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_LOGIN', $viewPrefix . 'auth.register'),
            'login' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_LOGIN', $viewPrefix . 'auth.login'),
            'confirm-password' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_CONFIRM_PASSWORD', $viewPrefix . 'auth.confirm-password'),
            'forgot-password' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_FORGOT_PASSWORD', $viewPrefix . 'auth.forgot-password'),
            'reset-password' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_RESET_PASSWORD', $viewPrefix . 'auth.reset-password'),
            'two-factor-challenge' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_TWO_FACTOR_CHALLENGE', $viewPrefix . 'auth.two-factor-challenge'),
            'two-factor-recovery' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_TWO_FACTOR_RECOVERY', $viewPrefix . 'auth.two-factor-recovery'),
            'verify-email' => env('LARAVEL_TOOLBOX_VIEWS_AUTH_VERIFY_EMAIL', $viewPrefix . 'auth.verify-email'),
        ],
    ],

    'acl_config' => null,

];
