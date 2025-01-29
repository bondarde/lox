<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\CmsTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCmsTemplates extends ListRecords
{
    protected static string $resource = CmsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
