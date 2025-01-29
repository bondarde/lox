<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\CmsTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCmsTemplate extends EditRecord
{
    protected static string $resource = CmsTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
