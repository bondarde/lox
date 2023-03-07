<?php

namespace BondarDe\LaravelToolbox\Constants;

use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;
use BondarDe\LaravelToolbox\Surveys\SurveyItemValues;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

abstract class  ValidationRules
{
    const REQUIRED = 'required';
    const OPTIONAL = 'nullable';
    const PROHIBITED = 'prohibited';
    const STOP_ON_FIRST_ERROR = 'bail';

    const TYPE_NUMERIC = 'numeric';
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'int';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_ARRAY = 'array';
    const TYPE_DATE = 'date';

    const DATE_YESTERDAY = 'yesterday';
    const DATE_TODAY = 'today';
    const DATE_TOMORROW = 'tomorrow';

    public static function min(int $val): string
    {
        return 'min:' . $val;
    }

    public static function max(int $val): string
    {
        return 'max:' . $val;
    }

    public static function email(string $validationMethods = 'filter'): string
    {
        return 'email:' . $validationMethods;
    }

    public static function size(int $val): string
    {
        return 'size:' . $val;
    }

    public static function dateFormat(string $format = 'Y-m-d'): string
    {
        return 'date-format:' . $format;
    }

    public static function dateBefore(string $dateOrField = self::DATE_TODAY): string
    {
        return 'before:' . $dateOrField;
    }

    public static function dateAfter(string $dateOrField = self::DATE_TODAY): string
    {
        return 'after:' . $dateOrField;
    }

    public static function regex(string $pattern): string
    {
        return 'regex:/' . $pattern . '/';
    }

    public static function unique(string $tableName, string $fieldName, string $exceptId): string
    {
        return 'unique:' . $tableName . ',' . $fieldName . ',' . $exceptId;
    }


    public static function requiredIfOtherFieldHasValue(Request $request, string $otherFieldName, $value): RequiredIf
    {
        return Rule::requiredIf(fn() => $request->get($otherFieldName) === $value);
    }

    public static function requiredIfOtherFieldHasAnyOfGivenValues(Request $request, string $otherFieldName, array $values): RequiredIf
    {
        return Rule::requiredIf(function () use ($request, $otherFieldName, $values) {
            $selectedValue = $request->get($otherFieldName);

            if (!$selectedValue) {
                return false;
            }

            return in_array($selectedValue, $values);
        });
    }

    public static function requiredIfOtherFieldContainsValue(Request $request, string $otherArrayFieldName, $value): RequiredIf
    {
        return Rule::requiredIf(function () use ($request, $otherArrayFieldName, $value) {
            $values = $request->get($otherArrayFieldName);

            return $values && in_array($value, $values);
        });
    }

    public static function requiredIfOtherFieldContainsAnyOfGivenValues(Request $request, string $otherArrayFieldName, array $valuesGiven): RequiredIf
    {
        return Rule::requiredIf(function () use ($request, $otherArrayFieldName, $valuesGiven) {
            if (!count($valuesGiven)) {
                return false;
            }

            $valuesSelected = $request->get($otherArrayFieldName, []);

            if (!count($valuesSelected)) {
                return false;
            }

            $intersection = array_intersect($valuesSelected, $valuesGiven);

            return count($intersection) > 0;
        });
    }

    public static function excludeOtherValuesIfSelected(string $exclusiveValue, string $labelClassName): callable
    {
        return function ($attribute, $values, $fail) use ($labelClassName, $exclusiveValue) {
            if ($values && in_array($exclusiveValue, $values) && count($values) > 1) {
                if (!is_subclass_of($labelClassName, SurveyItemValues::class)) {
                    throw new IllegalStateException($labelClassName . ' is not a subclass of ' . SurveyItemValues::class);
                }

                $fail(
                    'Sie haben „'
                    . $labelClassName::label($exclusiveValue)
                    . '“ gewählt, gleichzeitig andere Optionen ausgewählt.'
                );
            }
        };
    }
}
