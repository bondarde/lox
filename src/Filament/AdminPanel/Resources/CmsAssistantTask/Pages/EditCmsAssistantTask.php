<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsAssistantTask\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsAssistantTask\CmsAssistantTaskResource;
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
