<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\PermissionResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
