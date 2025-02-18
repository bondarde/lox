<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\Pages;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplate\RelationManagers\TemplateVariablesRelationManager;
use BondarDe\Lox\Filament\HasModelCountNavigationBadge;
use BondarDe\Lox\Models\CmsTemplate;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CmsTemplateResource extends Resource
{
    use HasModelCountNavigationBadge;

    protected static ?string $model = CmsTemplate::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?int $navigationSort = 120;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make(CmsTemplate::FIELD_LABEL)
                    ->label('Name'),
                Textarea::make(CmsTemplate::FIELD_CONTENT)
                    ->rows(10)
                    ->label('Content')
                    ->columnSpanFull(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(CmsTemplate::FIELD_CREATED_AT)
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make(CmsTemplate::FIELD_UPDATED_AT)
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make(CmsTemplate::FIELD_LABEL)
                    ->description(fn (CmsTemplate $cmsTemplate): string => 'Variables: ' . $cmsTemplate->{CmsTemplate::COUNT_TEMPLATE_VARIABLES})
                    ->label('Name'),
                TextColumn::make(CmsTemplate::COUNT_PAGES)
                    ->numeric()
                    ->label('Pages'),
            ])
            ->defaultSort(CmsTemplate::FIELD_UPDATED_AT, 'desc')
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
            TemplateVariablesRelationManager::class,
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('lox::lox.admin.cms.navigation_group_name');
    }

    public static function getSlug(): string
    {
        return __('lox::lox.admin.cms.templates.slug');
    }

    public static function getLabel(): string
    {
        return __('lox::lox.admin.cms.templates.label');
    }

    public static function getPluralLabel(): string
    {
        return __('lox::lox.admin.cms.templates.plural_label');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCmsTemplates::route('/'),
            'create' => Pages\CreateCmsTemplate::route('/create'),
            'view' => Pages\ViewCmsTemplate::route('/{record}'),
            'edit' => Pages\EditCmsTemplate::route('/{record}/edit'),
        ];
    }
}
