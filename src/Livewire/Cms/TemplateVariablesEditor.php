<?php

namespace BondarDe\Lox\Livewire\Cms;

use BondarDe\Lox\Constants\Cms\CmsTemplateVariableType;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;
use BondarDe\Lox\Repositories\CmsTemplateVariableRepository;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TemplateVariablesEditor extends Component
{
    public CmsTemplate $cmsTemplate;

    public bool $isAddingTemplateVariable = false;

    public string $newTvLabel;
    public CmsTemplateVariableType $newTvType = CmsTemplateVariableType::Html;

    public function createTv(): void
    {
        /** @var CmsTemplateVariableRepository $cmsTemplateVariableRepository */
        $cmsTemplateVariableRepository = app(CmsTemplateVariableRepository::class);

        $cmsTemplateVariableRepository->create([
            CmsTemplateVariable::FIELD_CMS_TEMPLATE_ID => $this->cmsTemplate->{CmsTemplate::FIELD_ID},
            CmsTemplateVariable::FIELD_LABEL => $this->newTvLabel,
            CmsTemplateVariable::FIELD_CONTENT_TYPE => $this->newTvType,
        ]);

        $this->reset(
            'newTvLabel',
            'newTvType',
        );
    }

    public function render(): View
    {
        return view('lox::livewire.cms.template-variables-editor', [
        ]);
    }
}
