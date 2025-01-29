<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\ApplicationModel;

use BondarDe\Lox\Filament\AdminPanel\Infolists\Components\ModelsListEntry;
use BondarDe\Lox\Filament\AdminPanel\Resources\ApplicationModel\Pages\ListApplicationModelResources;
use BondarDe\Lox\Filament\AdminPanel\Resources\ApplicationModel\Pages\ViewApplicationModelResource;
use BondarDe\Lox\Filament\AdminPanel\Resources\DatabaseRelation\DatabaseRelationResource;
use BondarDe\Lox\Filament\HasModelCountNavigationBadge;
use BondarDe\Lox\Models\Sushi\ApplicationModel;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ApplicationModelResource extends Resource
{
    use HasModelCountNavigationBadge;

    protected static ?string $model = ApplicationModel::class;
    protected static ?string $slug = 'models';

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 110;

    protected static ?string $navigationLabel = 'Models';
    protected static ?string $label = 'Model';
    protected static ?string $pluralLabel = 'Models';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('fullyQualifiedClassName')
                    ->formatStateUsing(fn (ApplicationModel $record) => new HtmlString(
                        '<span class="opacity-65 font-normal mr-px">' . $record->namespace . '\</span>'
                        . $record->className,
                    ))
                    ->weight(FontWeight::Bold)
                    ->columnSpanFull()
                    ->label('Model'),

                TextEntry::make('dbTableName')
                    ->placeholder('n/a')
                    ->url(function (?string $state): ?string {
                        if (! $state) {
                            return null;
                        }

                        return DatabaseRelationResource::getUrl(
                            'view',
                            [
                                'table:' . $state,
                            ],
                        );
                    })
                    ->label('DB table'),

                TextEntry::make('dbEntriesCount')
                    ->placeholder('n/a')
                    ->numeric()
                    ->label('DB entries'),

                ModelsListEntry::make('models')
                    ->columnSpanFull()
                    ->visible(fn (ApplicationModel $record) => $record->dbTableName)
                    ->label('Models'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('fullyQualifiedClassName')
                    ->formatStateUsing(fn (ApplicationModel $record) => new HtmlString(
                        '<span class="opacity-65 font-normal mr-px">' . $record->namespace . '\</span>'
                        . $record->className,
                    ))
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable()
                    ->label('Model'),

                TextColumn::make('dbTableName')
                    ->label('DB table')
                    ->placeholder('n/a')
                    ->url(function (?string $state): ?string {
                        if (! $state) {
                            return null;
                        }

                        return DatabaseRelationResource::getUrl(
                            'view',
                            [
                                'table:' . $state,
                            ],
                        );
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('dbEntriesCount')
                    ->label('DB entries')
                    ->placeholder('n/a')
                    ->numeric()
                    ->alignEnd()
                    ->sortable(),

            ])
            ->defaultSort('fullyQualifiedClassName')
            ->filters([
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplicationModelResources::route('/'),
            'view' => ViewApplicationModelResource::route('/{record}'),
        ];
    }
}
