<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsAssistantTaskResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsAssistantTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCmsAssistantTask extends EditRecord
{
    protected static string $resource = CmsAssistantTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
