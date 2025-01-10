<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources;

use BondarDe\Lox\Filament\AdminPanel\Resources\PermissionResource\Pages;
use BondarDe\Lox\Filament\HasModelCountNavigationBadge;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;

class PermissionResource extends Resource
{
    use HasModelCountNavigationBadge;

    protected static ?string $model = Permission::class;

    protected static ?int $navigationSort = 110;
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('guard_name')
                    ->label('Guard'),

                TextEntry::make('roles.name')
                    ->placeholder('n/a')
                    ->badge()
                    ->listWithLineBreaks(),
                TextEntry::make('users.name')
                    ->placeholder('n/a')
                    ->listWithLineBreaks(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('guard_name')
                    ->required()
                    ->label('Guard'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->searchable()
                    ->label('Guard'),
                TextColumn::make('roles.name')
                    ->badge()
                    ->placeholder('n/a')
                    ->listWithLineBreaks(),
                TextColumn::make('users.name')
                    ->placeholder('n/a')
                    ->listWithLineBreaks(),
            ])
            ->defaultSort('name')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'view' => Pages\ViewPermission::route('/{record}'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament-shield::filament-shield.nav.group');
    }
}
