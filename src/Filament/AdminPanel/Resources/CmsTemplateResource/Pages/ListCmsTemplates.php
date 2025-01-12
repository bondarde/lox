<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplateResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplateResource;
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
