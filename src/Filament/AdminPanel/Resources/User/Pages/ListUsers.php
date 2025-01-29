<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\User\Pages;

use BondarDe\Lox\Filament\AdminPanel\Resources\User\UserResource;
use BondarDe\Lox\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $allUsers = User::all();
        $roles = Role::all();

        return [
            'all' => Tab::make('Alle')
                ->badge($allUsers->count()),

            ...$roles->mapWithKeys(fn (Role $role) => [
                $role->name => Tab::make()
                    ->badge($role->users()->count())
                    ->modifyQueryUsing(
                        fn (Builder $query) => $query
                            ->whereHas(
                                User::REL_ROLES,
                                fn (Builder $query) => $query->where('id', $role->id),
                            ),
                    ),
            ]),
        ];
    }
}
