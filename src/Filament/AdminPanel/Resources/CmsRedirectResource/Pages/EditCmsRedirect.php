<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirectResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCmsRedirect extends EditRecord
{
    protected static string $resource = CmsRedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
