<?php

namespace BondarDe\Lox\View\Components;

use BondarDe\Lox\Surveys\SurveyStep;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class Survey extends Component
{
    private \BondarDe\Lox\Surveys\Survey $survey;

    public array $steps;
    public int $currentStepIndex;
    public int $previousStepIndex = -1;
    public int $nextStepIndex = -1;

    public ?Model $model;
    public string $stepFormTemplate;

    public string $formActionUri;
    public ?string $cancelUri;
    public ?string $cancelInfo;

    public bool $allowNextStepNavigation;

    public function __construct(
        string  $survey,
        string  $formActionUri,
        string  $cancelUri = null,
        string  $cancelInfo = null,
        bool    $allowNextStepNavigation = true,
        Model   $model = null,
        Request $request = null
    )
    {
        $this->survey = new $survey;
        $this->model = $model;

        $this->formActionUri = $formActionUri;
        $this->cancelUri = $cancelUri;
        $this->cancelInfo = $cancelInfo;

        $this->allowNextStepNavigation = $allowNextStepNavigation;

        $this->initFromRequest($request);
        $this->initSteps($this->survey->getSteps());
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


        $this->stepFormTemplate = $this->makeCurrentStepFormTemplate();

        if ($this->currentStepIndex > 0) {
            $this->previousStepIndex = $this->currentStepIndex - 1;
        }

        if ($this->currentStepIndex + 1 < count($steps)) {
            $this->nextStepIndex = $this->currentStepIndex + 1;
        }
    }

    private function makeCurrentStepFormTemplate(): string
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

    public function showStepLink($stepIndex): bool
    {
        if (!$this->model) {
            return false;
        }
        if ($this->currentStepIndex === $stepIndex) {
            return false;
        }
        if ($stepIndex > $this->currentStepIndex && !$this->allowNextStepNavigation) {
            return false;
        }

        return true;
    }

    public function toStepClasses(object $loop): string
    {
        $loop->index;
        $loop->first;
        $loop->last;

        $classNames = [
            'truncate whitespace-nowrap flex-1 p-4 border dark:border-gray-700',
        ];
        $classNames[] = $this->currentStepIndex === $loop->index ? 'link--active border-indigo-900' : 'bg-white dark:bg-gray-800 hidden md:block';
        $classNames[] = ($loop->first) ? 'rounded-l-lg' : 'border-l-0';
        $classNames[] = $loop->last ? 'rounded-r-lg' : '';

        return implode(' ', $classNames);
    }

    public function render(): View
    {
        return view('lox::components.survey.survey');
    }
}
