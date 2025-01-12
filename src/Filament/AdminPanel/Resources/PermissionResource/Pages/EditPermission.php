<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\PermissionResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
