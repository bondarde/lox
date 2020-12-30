<?php

namespace BondarDe\LaravelToolbox;

use BondarDe\LaravelToolbox\View\Components\Content;
use BondarDe\LaravelToolbox\View\Components\Form\Checkbox;
use BondarDe\LaravelToolbox\View\Components\Form\FormRow;
use BondarDe\LaravelToolbox\View\Components\Form\Input;
use BondarDe\LaravelToolbox\View\Components\Form\InputError;
use BondarDe\LaravelToolbox\View\Components\Form\Radio;
use BondarDe\LaravelToolbox\View\Components\Form\Select;
use BondarDe\LaravelToolbox\View\Components\Page;
use BondarDe\LaravelToolbox\View\Components\Survey;
use Illuminate\Support\ServiceProvider;

class LaravelToolboxServiceProvider extends ServiceProvider
{
    const COMPONENTS = [
        'page' => Page::class,
        'content' => Content::class,
        'form.form-row' => FormRow::class,
        'form.input' => Input::class,
        'form.input-error' => InputError::class,
        'form.checkbox' => Checkbox::class,
        'form.radio' => Radio::class,
        'form.select' => Select::class,
        'survey' => Survey::class,
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/components', 'laravel-toolbox');
        $this->loadViewComponentsAs('', self::COMPONENTS);

        $this->publishes([
            __DIR__ . '/../resources/scss/' => resource_path('scss/laravel-toolbox'),
        ], 'styles');

        $this->publishes([
            __DIR__ . '/../resources/tailwind/burger-menu' => resource_path('tailwind'),
            __DIR__ . '/../resources/tailwind/tailwind.config.js' => base_path('tailwind.config.js'),
        ], 'tailwind');
    }
}
