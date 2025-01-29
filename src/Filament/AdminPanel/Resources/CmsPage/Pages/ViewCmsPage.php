<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsPage\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPage\CmsPageResource;
use BondarDe\Lox\Models\CmsPage;
use Filament\Actions\EditAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\ViewRecord\Concerns\Translatable;

class ViewCmsPage extends ViewRecord
{
    use Translatable;

    protected static string $resource = CmsPageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (! isset($data[CmsPage::FIELD_PARENT_ID])) {
            $data[CmsPage::FIELD_PARENT_ID] = CmsPageResource::$defaultNoParentValue;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
