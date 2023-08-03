<?php

namespace BondarDe\Lox\View\Components\Form;

use BondarDe\Lox\Exceptions\IllegalStateException;
use BondarDe\Lox\Surveys\SurveyItemValues;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\View\Component;

abstract class FormComponent extends Component
{
    protected const CONTAINER_CLASS_DEFAULT = 'focus-within:border-blue-300 dark:focus-within:border-blue-700 focus-within:ring-blue-100 dark:focus-within:ring-blue-900';
    protected const CONTAINER_CLASS_ERROR = 'border-red-400 text-red-900 bg-red-50 focus-within:ring-red-100';

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

    protected static function toOptions($options, string $keyPattern): array
    {
        $type = gettype($options);

        switch ($type) {
            case 'array':
                return $options;
            case 'string':
                if (is_subclass_of($options, SurveyItemValues::class)) {
                    return $options::matching($keyPattern);
                }

                /** @noinspection PhpUnhandledExceptionInspection */
                throw new IllegalStateException($options . ' is not a subclass of ' . SurveyItemValues::class);
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        throw new IllegalStateException('Unsupported options type: ' . $type);
    }
}
