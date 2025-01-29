<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\Permission\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\Permission\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;
}
