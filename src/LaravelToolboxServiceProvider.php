<?php

namespace BondarDe\LaravelToolbox;

use BondarDe\LaravelToolbox\View\Components\Content;
use BondarDe\LaravelToolbox\View\Components\Form\FormRow;
use BondarDe\LaravelToolbox\View\Components\Form\Input;
use BondarDe\LaravelToolbox\View\Components\Form\InputError;
use Illuminate\Support\ServiceProvider;

class LaravelToolboxServiceProvider extends ServiceProvider
{
    const COMPONENTS = [
        'content' => Content::class,
        'form.form-row' => FormRow::class,
        'form.input' => Input::class,
        'form.input-error' => InputError::class,
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/components', 'laravel-toolbox');
        $this->loadViewComponentsAs('', self::COMPONENTS);
    }
}
