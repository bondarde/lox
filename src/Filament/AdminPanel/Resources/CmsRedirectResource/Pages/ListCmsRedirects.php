<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirectResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCmsRedirects extends ListRecords
{
    protected static string $resource = CmsRedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
