<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\PermissionResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPermission extends ViewRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
