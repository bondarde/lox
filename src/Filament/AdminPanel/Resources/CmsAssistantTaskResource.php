<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources;

use BondarDe\Lox\Filament\AdminPanel\Resources\CmsAssistantTaskResource\Pages;
use BondarDe\Lox\Models\CmsAssistantTask;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class CmsAssistantTaskResource extends Resource
{
    protected static ?string $model = CmsAssistantTask::class;
    protected static ?string $slug = 'cms-assistant-tasks';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'CMS';
    protected static ?int $navigationSort = 130;

    protected static ?string $label = 'Task';
    protected static ?string $pluralLabel = 'Tasks';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make(CmsAssistantTask::FIELD_TASK)
                    ->default(config('lox.cms.assistant.default_task'))
                    ->columnSpanFull()
                    ->required(),
                TextInput::make(CmsAssistantTask::FIELD_TOPIC)
                    ->columnSpanFull()
                    ->required(),
                TextInput::make(CmsAssistantTask::FIELD_LOCALE)
                    ->default(config('app.locale'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('status')
                    ->state(CmsAssistantTask::FIELD_LOCALE)
                    ->icon(function (CmsAssistantTask $record) {
                        if (! $record->{CmsAssistantTask::FIELD_EXECUTION_STARTED_AT}) {
                            return 'heroicon-o-clock';
                        }

                        if ($record->{CmsAssistantTask::FIELD_EXECUTION_FINISHED_AT}) {
                            return 'heroicon-o-check-circle';
                        }

                        return 'heroicon-o-x-circle';
                    })
                    ->color(function (CmsAssistantTask $record) {
                        if (! $record->{CmsAssistantTask::FIELD_EXECUTION_STARTED_AT}) {
                            return 'gray';
                        }

                        if ($record->{CmsAssistantTask::FIELD_EXECUTION_FINISHED_AT}) {
                            return 'success';
                        }

                        return 'danger';
                    }),
                TextColumn::make(CmsAssistantTask::FIELD_TASK)
                    ->wrap(),
                TextColumn::make(CmsAssistantTask::FIELD_TOPIC)
                    ->wrap(),
                TextColumn::make(CmsAssistantTask::FIELD_LOCALE),
                TextColumn::make(CmsAssistantTask::FIELD_EXECUTION_STARTED_AT)
                    ->label('Start')
                    ->placeholder('n/a')
                    ->since()
                    ->dateTimeTooltip(),
                TextColumn::make(CmsAssistantTask::FIELD_EXECUTION_FINISHED_AT)
                    ->label('Finished')
                    ->placeholder('n/a')
                    ->since()
                    ->dateTimeTooltip(),
            ])
            ->defaultSort(CmsAssistantTask::FIELD_ID, 'desc')
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
            'index' => Pages\ListCmsAssistantTasks::route('/'),
            'create' => Pages\CreateCmsAssistantTask::route('/create'),
            'view' => Pages\ViewCmsAssistantTask::route('/{record}'),
            'edit' => Pages\EditCmsAssistantTask::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Number::format(static::getModel()::count());
    }
}