<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPageResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplateResource;
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
            ->prepend(__('No template'), CmsPageResource::$defaultNoTemplateValue)
            ->toArray();
    }
}
