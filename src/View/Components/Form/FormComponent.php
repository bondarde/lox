<?php

namespace BondarDe\LaravelComponents\View\Components\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\View\Component;

abstract class FormComponent extends Component
{
    protected static function toValue($value, string $name, ?Model $model = null)
    {
        if ($value !== null) {
            return $value;
        }

        $old = old($name);

        if ($old !== null) {
            return $old;
        }

        if (!$model) {
            return null;
        }

        return $model->{$name};
    }

    protected static function hasErrors(string $name): bool
    {
        $errors = Session::get('errors', new MessageBag);
        $messages = $errors->getMessages();

        return isset($messages[$name]);
    }

    protected static function renderProps(array $props): string
    {
        $props = array_map(function ($key, $val) {
            return $key . '="' . $val . '"' . "\n";
        }, array_keys($props), $props);

        return implode(' ', $props);
    }
}
