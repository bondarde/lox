<?php

namespace BondarDe\Lox\View\Components;

use BondarDe\Lox\Surveys\SurveyStep;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class SurveyView extends Component
{
    public array $templates;
    public ?Model $model;

    private \BondarDe\Lox\Surveys\Survey $survey;
    private array $steps;

    public function __construct(
        string $survey,
        Model  $model = null
    )
    {
        $this->survey = new $survey;
        $this->model = $model;
        $this->initSteps($this->survey->getSteps());
        $this->templates = array_map(function ($idx) {
            return $this->toStepFormTemplate($idx);
        }, array_keys($this->steps));
    }

    private function initSteps(array $steps): void
    {
        $this->steps = array_map(function (string $stepClassName): SurveyStep {
            return new $stepClassName;
        }, $steps);
    }

    private function toStepFormTemplate(int $stepIdx): string
    {
        $step = $this->steps[$stepIdx];
        $surveyTemplateId = $this->survey->getId();
        $stepTemplateId = $step->getId();

        return sprintf(
            "surveys.%s.%s.%s",
            $surveyTemplateId,
            SurveyStep::MODE_VIEW,
            $stepTemplateId,
        );
    }

    public function render(): View
    {
        return view('lox::survey.survey-view');
    }
}
