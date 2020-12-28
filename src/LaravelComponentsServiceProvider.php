<?php

namespace BondarDe\LaravelComponents;

use BondarDe\LaravelComponents\View\Components\Form\Input;
use BondarDe\LaravelComponents\View\Components\Form\InputError;
use Illuminate\Support\ServiceProvider;

class LaravelComponentsServiceProvider extends ServiceProvider
{
    const COMPONENTS = [
        'form.input' => Input::class,
        'form.input-error' => InputError::class,
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/components', 'laravel-components');
        $this->loadViewComponentsAs('', self::COMPONENTS);
    }
}
