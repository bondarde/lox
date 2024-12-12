<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\UserResource\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
