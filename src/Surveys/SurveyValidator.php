<?php

namespace BondarDe\LaravelToolbox\Surveys;

use Bond211\Utils\Support\Arrays;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SurveyValidator
{
    public static function toValidated(
        string $surveyClass,
        Request $request,
        ?Model $model
    ): array
    {
        if (!$request->has(SurveyStep::CURRENT_STEP_FORM_PARAMETER)) {
            throw new Exception('Missing required "' . SurveyStep::CURRENT_STEP_FORM_PARAMETER . '" attribute.');
        }

        $step = $request->get(SurveyStep::CURRENT_STEP_FORM_PARAMETER);
        $currentStepIndex = $step - 1;

        /** @var Survey $survey */
        $survey = new $surveyClass;

        $stepClasses = $survey->getSteps();
        $currentStepClass = $stepClasses[$currentStepIndex];

        /** @var SurveyStep $currentStep */
        $currentStep = new $currentStepClass;

        $rules = $currentStep->getRules($request, $model);
        $messages = Arrays::flattenKeys($currentStep->getMessages());
        $customAttributes = $currentStep->getCustomAttributes();

        $fields = array_keys($rules);
        $data = $currentStep->prepareForValidation($request->only($fields));

        $validator = Validator::make(
            $data,
            $rules,
            $messages,
            $customAttributes,
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
