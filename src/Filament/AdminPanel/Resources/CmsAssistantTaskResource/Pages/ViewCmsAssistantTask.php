<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsAssistantTaskResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsAssistantTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCmsAssistantTask extends ViewRecord
{
    protected static string $resource = CmsAssistantTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
