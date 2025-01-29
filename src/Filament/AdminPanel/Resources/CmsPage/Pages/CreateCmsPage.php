<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsPage\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPage\CmsPageResource;
use BondarDe\Lox\Models\CmsPage;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateCmsPage extends CreateRecord
{
    use Translatable;

    protected static string $resource = CmsPageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data[CmsPage::FIELD_PARENT_ID] === CmsPageResource::$defaultNoParentValue) {
            $data[CmsPage::FIELD_PARENT_ID] = null;
        }
        if ($data[CmsPage::FIELD_CMS_TEMPLATE_ID] === CmsPageResource::$defaultNoTemplateValue) {
            $data[CmsPage::FIELD_CMS_TEMPLATE_ID] = null;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
