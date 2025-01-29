<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirect\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirect\CmsRedirectResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCmsRedirect extends ViewRecord
{
    protected static string $resource = CmsRedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
