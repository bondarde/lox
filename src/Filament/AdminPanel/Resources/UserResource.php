<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources;

use App\Models\User;
use BondarDe\Lox\Filament\AdminPanel\Resources\UserResource\Pages;
use BondarDe\Lox\Filament\HasModelCountNavigationBadge;
use BondarDe\Lox\Models\SsoIdentifier;
use BondarDe\Lox\Models\User as LoxUser;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource
{
    use HasModelCountNavigationBadge;

    protected static ?string $model = User::class;
    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 100;

    protected static ?string $label = 'User';
    protected static ?string $pluralLabel = 'Users';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make(LoxUser::FIELD_NAME)
                    ->copyable(),
                TextEntry::make(LoxUser::FIELD_EMAIL)
                    ->copyable(),
                TextEntry::make(LoxUser::REL_ROLES . '.name')
                    ->placeholder('n/a')
                    ->badge()
                    ->listWithLineBreaks(),
                TextEntry::make(LoxUser::REL_PERMISSIONS . '.name')
                    ->placeholder('n/a')
                    ->badge()
                    ->listWithLineBreaks(),

                RepeatableEntry::make(LoxUser::REL_SSO_IDENTIFIERS)
                    ->label('SSO')
                    ->schema([
                        TextEntry::make(SsoIdentifier::FIELD_PROVIDER_NAME)
                            ->formatStateUsing(fn (string $state): string => mb_ucfirst($state))
                            ->helperText(fn (SsoIdentifier $ssoIdentifier): string => $ssoIdentifier->{SsoIdentifier::FIELD_PROVIDER_ID})
                            ->hiddenLabel(),
                    ])
                    ->placeholder('n/a'),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make(LoxUser::FIELD_NAME)
                    ->required(),
                TextInput::make(LoxUser::FIELD_EMAIL)
                    ->required(),

                CheckboxList::make(LoxUser::REL_ROLES)
                    ->relationship(LoxUser::REL_ROLES, 'name')
                    ->searchable(),
                Select::make(LoxUser::REL_PERMISSIONS)
                    ->relationship(LoxUser::REL_PERMISSIONS, 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(LoxUser::FIELD_ID)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                TextColumn::make(LoxUser::FIELD_EMAIL)
                    ->description(fn (User $record) => Str::limit($record->{LoxUser::FIELD_NAME}, 40))
                    ->label('User')
                    ->searchable([
                        LoxUser::FIELD_EMAIL,
                        LoxUser::FIELD_NAME,
                    ]),

                TextColumn::make(User::CREATED_AT)
                    ->label('Created')
                    ->description(fn (User $record) => $record->{User::CREATED_AT}->format('d.m.Y'))
                    ->since()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make(User::UPDATED_AT)
                    ->label('Updated')
                    ->description(fn (User $record) => $record->{User::UPDATED_AT}->format('d.m.Y H:i'))
                    ->since()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make(LoxUser::REL_ROLES . '.name')
                    ->placeholder('n/a')
                    ->label('Roles')
                    ->listWithLineBreaks()
                    ->badge()
                    ->searchable(),

                TextColumn::make(LoxUser::REL_PERMISSIONS . '.name')
                    ->placeholder('n/a')
                    ->label('Perm')
                    ->listWithLineBreaks()
                    ->badge()
                    ->searchable(),

                TextColumn::make(LoxUser::REL_SSO_IDENTIFIERS . '.' . SsoIdentifier::FIELD_PROVIDER_NAME)
                    ->label('SSO')
                    ->wrap()
                    ->placeholder('n/a')
                    ->badge(),
            ])
            ->defaultSort(LoxUser::FIELD_ID, 'desc')
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

    public static function getNavigationGroup(): ?string
    {
        return __('filament-shield::filament-shield.nav.group');
    }
}
