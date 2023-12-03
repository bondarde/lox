<?php

use BondarDe\Lox\LoxServiceProvider;

$viewPrefix = LoxServiceProvider::NAMESPACE . '::';

return [
    'page' => [
        'height' => env('LOX_PAGE_HEIGHT'),
        'background' => env('LOX_PAGE_BACKGROUND'),
        'text' => env('LOX_PAGE_TEXT'),
    ],

    'views' => [
        'profile' => [
            'index' => env('LOX_VIEWS_AUTH_LOGIN', $viewPrefix . 'profile.index'),
        ],
        'auth' => [
            'register' => env('LOX_VIEWS_AUTH_LOGIN', $viewPrefix . 'auth.register'),
            'login' => env('LOX_VIEWS_AUTH_LOGIN', $viewPrefix . 'auth.login'),
            'confirm-password' => env('LOX_VIEWS_AUTH_CONFIRM_PASSWORD', $viewPrefix . 'auth.confirm-password'),
            'forgot-password' => env('LOX_VIEWS_AUTH_FORGOT_PASSWORD', $viewPrefix . 'auth.forgot-password'),
            'reset-password' => env('LOX_VIEWS_AUTH_RESET_PASSWORD', $viewPrefix . 'auth.reset-password'),
            'two-factor-challenge' => env('LOX_VIEWS_AUTH_TWO_FACTOR_CHALLENGE', $viewPrefix . 'auth.two-factor-challenge'),
            'two-factor-recovery' => env('LOX_VIEWS_AUTH_TWO_FACTOR_RECOVERY', $viewPrefix . 'auth.two-factor-recovery'),
            'verify-email' => env('LOX_VIEWS_AUTH_VERIFY_EMAIL', $viewPrefix . 'auth.verify-email'),
        ],
    ],

    'profile' => [
        'allow-delete' => env('LOX_PROFILE_ALLOW_DELETE', false),
    ],

    'acl_config' => null,

    'sso' => [
        'column_prefix' => env('LOX_SSO_COLUMN_PREFIX', 'sso'),
    ],

    'cms' => [
        'fallback_route_enabled' => env('LOX_CMS_FALLBACK_ROUTE_ENABLED', true),
        'assistant' => [
            'model' => env('LOX_CMS_ASSISTANT_MODEL', 'gpt-4'),
            'default_task' => env('LOX_CMS_ASSISTANT_DEFAULT_TASK'),
        ],
    ],
];
