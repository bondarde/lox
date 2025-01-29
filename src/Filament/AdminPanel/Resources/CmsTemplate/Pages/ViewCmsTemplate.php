<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\CmsTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCmsTemplate extends ViewRecord
{
    protected static string $resource = CmsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
