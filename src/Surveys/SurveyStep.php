<?php

namespace BondarDe\LaravelToolbox\Surveys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface SurveyStep
{
    public const CURRENT_STEP_FORM_PARAMETER = '_current_survey_step';
    public const CURRENT_STEP_QUERY_PARAMETER = 'step';

    public const MODE_EDIT = 'edit';
    public const MODE_VIEW = 'view';

    public function getId(): string;

    public function getLabelHtml(): string;

    public function getDescriptionHtml(): string;

    public function getRules(Request $request, Model $model): array;

    public function getMessages(): array;

    public function getCustomAttributes(): array;

    public function prepareForValidation(array $data, Request $request): array;
}
