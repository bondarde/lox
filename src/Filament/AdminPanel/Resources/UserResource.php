<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources;

use BondarDe\Lox\Filament\AdminPanel\Resources\UserResource\Pages;
use BondarDe\Lox\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 100;

    protected static ?string $label = 'User';
    protected static ?string $pluralLabel = 'Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(User::FIELD_ID)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                TextColumn::make(User::FIELD_EMAIL)
                    ->description(fn (User $record) => Str::limit($record->{User::FIELD_NAME}, 40))
                    ->label('User')
                    ->searchable([
                        User::FIELD_EMAIL,
                        User::FIELD_NAME,
                    ]),

                TextColumn::make(User::CREATED_AT)
                    ->label('Created')
                    ->description(fn (User $record) => $record->{User::CREATED_AT}->format('d.m.Y'))
                    ->since()
                    ->sortable(),

                TextColumn::make(User::UPDATED_AT)
                    ->label('Updated')
                    ->description(fn (User $record) => $record->{User::UPDATED_AT}->format('d.m.Y H:i'))
                    ->since()
                    ->sortable(),

                TextColumn::make(User::REL_ROLES . '.name')
                    ->placeholder('n/a')
                    ->label('Roles')
                    ->listWithLineBreaks()
                    ->badge()
                    ->searchable(),

                TextColumn::make(User::REL_PERMISSIONS . '.name')
                    ->label('Perm')
                    ->listWithLineBreaks()
                    ->badge()
                    ->placeholder('n/a')
                    ->searchable(),
            ])
            ->defaultSort(User::FIELD_ID, 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Impersonate::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Number::format(static::getModel()::count());
    }
}
