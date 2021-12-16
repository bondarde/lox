<?php

namespace BondarDe\LaravelToolbox\View\Components;

use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;
use BondarDe\LaravelToolbox\ModelSummary\ModelSummarizable;
use BondarDe\LaravelToolbox\ModelSummary\ModelSummaryFiltered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class ModelSummary extends Component
{
    public Model $model;
    public array $attributeNames;
    public array $attributesValues;

    public function __construct(
        Model $model
    )
    {
        $this->model = $model;
        $this->attributesValues = $model->toArray();

        $this->attributeNames = self::toVisibleAttributeNames($model, $this->attributesValues);
    }

    public function renderName($attributeName): string
    {
        if (is_subclass_of($this->model, ModelSummarizable::class)) {
            $formatters = $this->model->getModelSummaryAttributeNameFormatters();

            if (isset($formatters[$attributeName])) {
                $formatter = $formatters[$attributeName];

                if (is_string($formatter)) {
                    return $formatter;
                }

                return $formatter($this->model);
            }
        }

        return Str::of($attributeName)
            ->snake()
            ->replace('_', ' ')
            ->title();
    }

    public function renderValue($attributeName): string
    {
        if (is_subclass_of($this->model, ModelSummarizable::class)) {
            $formatters = $this->model->getModelSummaryAttributeValueFormatters();

            if (isset($formatters[$attributeName])) {
                $formatter = $formatters[$attributeName];

                if (is_string($formatter)) {
                    return $formatter;
                }

                return $formatter($this->model);
            }
        }

        $value = $this->attributesValues[$attributeName] ?? '—';

        return nl2br(e($value));
    }

    private static function toVisibleAttributeNames(Model $model, array $attributesValues): array
    {
        $allAttributeNames = array_keys($attributesValues);

        if (is_subclass_of($model, ModelSummaryFiltered::class)) {
            $visibleAttributes = $model->getModelSummaryVisibleAttributes();
            $hiddenAttributes = $model->getModelSummaryHiddenAttributes();

            if ($visibleAttributes !== null) {
                return array_intersect($allAttributeNames, $visibleAttributes);
            } else if ($hiddenAttributes !== null) {
                return array_diff($allAttributeNames, $hiddenAttributes);
            }

            throw new IllegalStateException('Either visible or hidden attributes list is required.');
        }

        return $allAttributeNames;
    }

    public function render()
    {
        return view('laravel-toolbox::model-summary');
    }
}
