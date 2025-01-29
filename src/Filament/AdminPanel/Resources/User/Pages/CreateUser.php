<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\User\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\User\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
