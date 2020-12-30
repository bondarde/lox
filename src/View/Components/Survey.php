<?php

namespace BondarDe\LaravelToolbox\View\Components;

use BondarDe\LaravelToolbox\Surveys\SurveyStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class Survey extends Component
{
    private \BondarDe\LaravelToolbox\Surveys\Survey $survey;

    public array $steps;
    public int $currentStepIndex;
    public int $previousStepIndex = -1;
    public int $nextStepIndex = -1;

    public string $formActionUri;
    public ?Model $model;
    public string $stepFormTemplate;

    public function __construct(
        string $survey,
        string $formActionUri,
        Model $model = null,
        Request $request = null
    )
    {
        $this->initFromRequest($request);
        $this->survey = new $survey;
        $this->initSteps($this->survey->getSteps());

        $this->formActionUri = $formActionUri;
        $this->model = $model;
    }

    private function initFromRequest(Request $request)
    {
        $step = $request->get(SurveyStep::CURRENT_STEP_QUERY_PARAMETER, 1);
        $this->currentStepIndex = $step - 1;
    }

    private function initSteps(array $steps): void
    {
        $this->steps = array_map(function (string $stepClassName): SurveyStep {
            return new $stepClassName;
        }, $steps);


        $this->stepFormTemplate = $this->makeStepFormTemplate();

        if ($this->currentStepIndex > 0) {
            $this->previousStepIndex = $this->currentStepIndex - 1;
        }

        if ($this->currentStepIndex + 1 < count($steps)) {
            $this->nextStepIndex = $this->currentStepIndex + 1;
        }
    }

    private function makeStepFormTemplate(): string
    {
        $currentStep = $this->steps[$this->currentStepIndex];
        $surveyTemplateId = $this->survey->getId();
        $stepTemplateId = $currentStep->getId();

        return sprintf(
            "surveys.%s.%s.%s",
            $surveyTemplateId,
            SurveyStep::MODE_EDIT,
            $stepTemplateId,
        );
    }

    public function render()
    {
        return view('laravel-toolbox::survey.survey');
    }
}
