<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsTemplateResource\RelationManagers;

use BondarDe\Lox\Constants\Cms\CmsTemplateVariableType;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class TemplateVariablesRelationManager extends RelationManager
{
    protected static string $relationship = CmsTemplate::REL_TEMPLATE_VARIABLES;

    protected static ?string $label = 'Template Variable';
    protected static ?string $pluralLabel = 'Template Variables';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make(CmsTemplateVariable::FIELD_LABEL)
                    ->required()
                    ->maxLength(255),

                Forms\Components\Radio::make(CmsTemplateVariable::FIELD_CONTENT_TYPE)
                    ->options(CmsTemplateVariableType::class)
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute(CmsTemplateVariable::FIELD_LABEL)
            ->columns([
                Tables\Columns\TextColumn::make(CmsTemplateVariable::FIELD_LABEL)
                    ->prefix(new HtmlString('<span class="opacity-50">$</span>'))
                    ->description(fn (CmsTemplateVariable $record): string => $record->{CmsTemplateVariable::FIELD_CONTENT_TYPE}->label()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
