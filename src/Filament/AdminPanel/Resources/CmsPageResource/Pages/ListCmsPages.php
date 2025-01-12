<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsPageResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPageResource;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListCmsPages extends ListRecords
{
    use Translatable;

    protected static string $resource = CmsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            LocaleSwitcher::make(),
        ];
    }
}
