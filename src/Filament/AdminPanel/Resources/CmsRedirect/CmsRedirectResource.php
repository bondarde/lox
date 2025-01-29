<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirect;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsRedirect\Pages;
use BondarDe\Lox\Filament\HasModelCountNavigationBadge;
use BondarDe\Lox\Models\CmsRedirect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CmsRedirectResource extends Resource
{
    use HasModelCountNavigationBadge;

    protected static ?string $model = CmsRedirect::class;
    protected static ?string $slug = 'cms-redirects';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-start-on-rectangle';
    protected static ?string $navigationGroup = 'CMS';
    protected static ?int $navigationSort = 110;

    protected static ?string $label = 'Redirect';
    protected static ?string $pluralLabel = 'Redirects';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make(CmsRedirect::FIELD_PATH)
                    ->label('URL')
                    ->required(),
                TextInput::make(CmsRedirect::FIELD_TARGET)
                    ->label('Target')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(CmsRedirect::FIELD_CREATED_AT)
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make(CmsRedirect::FIELD_UPDATED_AT)
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make(CmsRedirect::FIELD_ID)
                    ->label('ID')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make(CmsRedirect::FIELD_PATH)
                    ->label('URL')
                    ->searchable(),
                TextColumn::make(CmsRedirect::FIELD_TARGET)
                    ->label('Target')
                    ->searchable(),
            ])
            ->defaultSort(CmsRedirect::FIELD_UPDATED_AT, 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCmsRedirects::route('/'),
            'create' => Pages\CreateCmsRedirect::route('/create'),
            'view' => Pages\ViewCmsRedirect::route('/{record}'),
            'edit' => Pages\EditCmsRedirect::route('/{record}/edit'),
        ];
    }
}
