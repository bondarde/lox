<?php

namespace BondarDe\LaravelToolbox;

use BondarDe\LaravelToolbox\View\Components\Buttons\DangerButton;
use BondarDe\LaravelToolbox\View\Components\Buttons\DefaultButton;
use BondarDe\LaravelToolbox\View\Components\Buttons\LinkButton;
use BondarDe\LaravelToolbox\View\Components\Buttons\SuccessButton;
use BondarDe\LaravelToolbox\View\Components\Content;
use BondarDe\LaravelToolbox\View\Components\Form\Boolean;
use BondarDe\LaravelToolbox\View\Components\Form\Checkbox;
use BondarDe\LaravelToolbox\View\Components\Form\FormActions;
use BondarDe\LaravelToolbox\View\Components\Form\FormRow;
use BondarDe\LaravelToolbox\View\Components\Form\Input;
use BondarDe\LaravelToolbox\View\Components\Form\InputError;
use BondarDe\LaravelToolbox\View\Components\Form\Radio;
use BondarDe\LaravelToolbox\View\Components\Form\Select;
use BondarDe\LaravelToolbox\View\Components\Page;
use BondarDe\LaravelToolbox\View\Components\RelativeTimestamp;
use BondarDe\LaravelToolbox\View\Components\Survey;
use BondarDe\LaravelToolbox\View\Components\UserMessages;
use BondarDe\LaravelToolbox\View\Components\ValidationErrors;
use Illuminate\Support\ServiceProvider;

class LaravelToolboxServiceProvider extends ServiceProvider
{
    const NAMESPACE = 'laravel-toolbox';

    const COMPONENTS = [
        'page' => Page::class,
        'content' => Content::class,
        'form.form-row' => FormRow::class,
        'form.form-actions' => FormActions::class,
        'form.input' => Input::class,
        'form.input-error' => InputError::class,
        'form.checkbox' => Checkbox::class,
        'form.radio' => Radio::class,
        'form.boolean' => Boolean::class,
        'form.select' => Select::class,
        'survey' => Survey::class,
        'validation-errors' => ValidationErrors::class,
        'user-messages' => UserMessages::class,

        'button' => DefaultButton::class,
        'button-success' => SuccessButton::class,
        'button-danger' => DangerButton::class,
        'button-link' => LinkButton::class,

        'relative-timestamp' => RelativeTimestamp::class,
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/components', self::NAMESPACE);
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
