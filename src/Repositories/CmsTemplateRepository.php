<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPage\CmsPageResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\CmsTemplateResource;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;

class CmsTemplateRepository extends ModelRepository
{
    public function model(): string
    {
        return CmsTemplate::class;
    }

    public function formOptions(): array
    {
        return $this->query()
            ->orderBy(CmsTemplate::FIELD_LABEL)
            ->get()
            ->keyBy(CmsTemplate::FIELD_ID)
            ->map(fn (CmsTemplate $cmsTemplate) => $cmsTemplate->{CmsTemplate::FIELD_LABEL} . ' [' . $cmsTemplate->{CmsTemplate::FIELD_ID} . ']')
            ->prepend(__('lox::lox.admin.cms.pages.no_template'), CmsPageResource::$defaultNoTemplateValue)
            ->toArray();
    }
}
