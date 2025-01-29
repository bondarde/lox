<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\User\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\User\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Impersonate::make(),
            Actions\EditAction::make(),
        ];
    }
}
