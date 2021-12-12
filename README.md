# Laravel Toolbox


## Installation

    composer require bondarde/laravel-toolbox


### Styles

Publish:

    php artisan vendor:publish --provider="BondarDe\LaravelToolbox\LaravelToolboxServiceProvider" --tag=styles

Add them to your `resources/scss/app.scss`:

    @tailwind base;
    @tailwind components;
    @tailwind utilities;

    @import 'laravel-toolbox/base';
    @import 'laravel-toolbox/tools';
    @import 'laravel-toolbox/boolean';


Tailwind config:

    php artisan vendor:publish --provider="BondarDe\LaravelToolbox\LaravelToolboxServiceProvider" --tag=tailwind


Burger menu as Tailwind plugin:

    php artisan vendor:publish --provider="BondarDe\LaravelToolbox\LaravelToolboxServiceProvider" --tag=tailwind-burger-menu


### Laravel Mix & Tailwind CSS

`package.json`:

    {
        "private": true,
        "scripts": {
            "development": "mix",
            "watch": "mix watch",
            "watch-poll": "mix watch -- --watch-options-poll=1000",
            "hot": "mix watch --hot",
            "production": "mix --production"
        },
        "devDependencies": {
            "autoprefixer": "^10.4.0",
            "laravel-mix": "^6.0.5",
            "postcss": "^8.4.4",
            "resolve-url-loader": "^3.1.0",
            "sass": "^1.30.0",
            "sass-loader": "^8.0.2",
            "tailwindcss": "^3.0.1"
        }
    }


### Laravel Mix Configuration

    touch webpack.mix.js


Configuration:

    const mix = require('laravel-mix')
    const tailwindcss = require('tailwindcss')

    // avoid creation of mix-manifest.json
    Mix.manifest.refresh = _ => void 0


    // adjust output directory for production build
    if (mix.inProduction()) {
        mix
            .setPublicPath('./.build/dist')
            .disableNotifications()
    }


    // Mix build
    mix
        .js('resources/js/app.js', 'js')
        .sass('resources/scss/app.scss', 'css', {}, [
            tailwindcss('./tailwind.config.js'),
        ])


Compile:

    npx mix


## Usage

Page structure:

    <x-page
        title="Page Title"
        h1="Headline"
    >
        <p>Your page content, beautifully staged.</p>
    </x-page>


For page component you have to create page header and footer:

    php artisan make:component PageHeader
    php artisan make:component PageFooter


### Forms

    <x-form-row
        for="input-name"
    >
        ...
    </x-form-row>


### Buttons

TBD
