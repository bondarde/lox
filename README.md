# LOX


## Installation

    composer require bondarde/lox

    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"


If needed, customize table names in `config/permission.php`, e.g.:

    'table_names' => [
        'roles'                 => 'acl_roles',
        'permissions'           => 'acl_permissions',
        'model_has_permissions' => 'acl_model_has_permissions',
        'model_has_roles'       => 'acl_model_has_roles',
        'role_has_permissions'  => 'acl_role_has_permissions',
    ],


Run migrations:

    php artisan migrate


If needed, add middleware aliases to the `app/Http/Kernel.php` file, in the `$middlewareAliases` array:

    protected $middlewareAliases = [
        …
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        …
    ];


If needed, grant "super-admin" role all permissions in `AuthServiceProvider`'s `boot()` method:

    Gate::before(
        fn($user, $ability) => $user->hasRole(AclSetupData::ROLE_SUPER_ADMIN) && $ability !== AclSetupData::PERMISSION_VIEW_MODEL_META_DATA
            ? true
            : null
    );


Create super-admin role and all configured roles/permissions:

    php artisan acl:update-roles-and-permission


After signing up, assign admin group to (your) user by ID or e-mail address:

    php artisan acl:make-super-admin 1

or:

    php artisan acl:make-super-admin mail@example.com


Publish config:

    php artisan vendor:publish --provider="BondarDe\Lox\LoxServiceProvider" --tag=config

This command also publishes:
- `package.json`
- `postcss.config.json`
- `tailwind.config.js`
- `vite.config.js`


### Styles

Publish:

    php artisan vendor:publish --provider="BondarDe\Lox\LoxServiceProvider" --tag=styles

Add them to your `resources/scss/app.scss`:

    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    @import 'lox/base';
    @import 'lox/tools';
    @import 'lox/boolean';


Tailwind config:

    php artisan vendor:publish --provider="BondarDe\Lox\LoxServiceProvider" --tag=tailwind


Burger menu as Tailwind plugin:

    php artisan vendor:publish --provider="BondarDe\Lox\LoxServiceProvider" --tag=tailwind-burger-menu





### Laravel Vite & Tailwind CSS

`package.json`:

    {
        "private": true,
        "scripts": {
            "dev": "vite",
            "build": "vite build"
        },
        "devDependencies": {
            "autoprefixer": "^10.4.0",
            "laravel-vite-plugin": "^0.5.2",
            "postcss": "^8.4.4",
            "sass": "^1.30.0",
            "sass-loader": "^12.6.0",
            "tailwindcss": "^3.2.0",
            "vite": "^3.0.4"
        }
    }


## Build and Deployment

Build for different stages:

    composer/bin/dep build stage=test
    composer/bin/dep deploy stage=test


For **local**  OPCache reset, a call to `http://127.0.0.1/opcache-reset.php` has to call PHP’s `opcache_clear()`

If not possible, add in `deploy.php`:

    set('opcache_reset_mode', 'remote');


User `deployer` should be able to execute `sudo` without password prompt for `chmod`, `chown` and `chgrp`:

    sudo visudo


    deployer ALL=(ALL:ALL) NOPASSWD: /usr/bin/chmod *
    deployer ALL=(ALL:ALL) NOPASSWD: /usr/bin/chown *
    deployer ALL=(ALL:ALL) NOPASSWD: /usr/bin/chgrp *


### Vite Builds

    npm run vite

    npm run vite build


## Usage

Page structure:

    <x-page
        title="Page Title"
        h1="Headline"
    >
        <p>Your page content, beautifully staged.</p>
    </x-page>


For page component you have to create page header and footer:

    php artisan make:component HtmlHeader
    php artisan make:component PageHeader
    php artisan make:component PageFooter

    php artisan make:component AdminPage


### Forms

    <x-form-row
        for="input-name"
    >
        ...
    </x-form-row>


### Buttons

TBD









### FortifyServiceProvider

Publish:

    php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"


Add in `boot()`:

    Fortify::registerView(config('lox.views.auth.register'));
    Fortify::loginView(config('lox.views.auth.login'));
    Fortify::confirmPasswordView(config('lox.views.auth.confirm-password'));
    Fortify::requestPasswordResetLinkView(config('lox.views.auth.forgot-password'));
    Fortify::resetPasswordView(config('lox.views.auth.reset-password'));
    Fortify::twoFactorChallengeView(config('lox.views.auth.two-factor-challenge'));
    Fortify::verifyEmailView(config('lox.views.auth.verify-email'));


In `config/app.php` add service provider:

    \App\Providers\FortifyServiceProvider::class,


Database Session storage:

    php artisan session:table

    php artisan migrate


### SSO

Add `"sso"` to `features` array in `config/fortify.php`.

In `config/fortify-options.php`, add SSO providers, e.g.:

    return [
        'sso' => [
            'apple' => true,
            'facebook' => true,
            'twitter' => true,
        ],
    ];





For each provider, install Socialite Providers package:

    composer require socialiteproviders/<provider>

Follow installation steps:
https://socialiteproviders.com/


