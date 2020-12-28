<?php

namespace De\Bondar\LaravelComponents;

use De\Bondar\LaravelComponents\View\Components\Form\Input;
use Illuminate\Support\ServiceProvider;

class LaravelComponentsServiceProvider extends ServiceProvider
{
    const COMPONENTS = [
        'form.input' => Input::class,
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/components', 'laravel-components');
        $this->loadViewComponentsAs('', self::COMPONENTS);
    }
}
