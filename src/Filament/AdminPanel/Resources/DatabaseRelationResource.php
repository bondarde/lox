<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources;

use BondarDe\Lox\Filament\AdminPanel\Resources\DatabaseRelationResource\Pages\ListDatabaseRelations;
use BondarDe\Lox\Filament\AdminPanel\Resources\DatabaseRelationResource\Pages\ViewDatabaseRelation;
use BondarDe\Lox\Filament\HasModelCountNavigationBadge;
use BondarDe\Lox\Models\Sushi\DatabaseRelation;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\View;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Console\TableCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Number;

class DatabaseRelationResource extends Resource
{
    use HasModelCountNavigationBadge;

    protected static ?string $model = DatabaseRelation::class;
    protected static ?string $slug = 'database';

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 100;

    protected static ?string $navigationLabel = 'Database';
    protected static ?string $label = 'Database relation';
    protected static ?string $pluralLabel = 'Database relations';

    public static function infolist(Infolist $infolist): Infolist
    {
        $model = $infolist->getRecord();
        Artisan::call(TableCommand::class, [
            'table' => $model->label,
            '--json' => 1,
        ]);
        $output = Artisan::output();
        $tableStatus = json_decode($output);

        return $infolist
            ->schema([
                TextEntry::make('label')
                    ->weight(FontWeight::Bold)
                    ->label('Name'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('schema')
                    ->placeholder('n/a'),
                TextEntry::make('collation')
                    ->placeholder('n/a'),
                TextEntry::make('size')
                    ->tooltip(fn (int $state) => Number::format($state))
                    ->formatStateUsing(fn (int $state) => Number::fileSize($state)),
                TextEntry::make('rows'),
                TextEntry::make('engine')
                    ->placeholder('n/a'),
                TextEntry::make('comment')
                    ->placeholder('n/a'),
                View::make('lox::admin.system.database.table')
                    ->viewData([
                        'size' => $tableStatus->table->size,
                        'columns' => $tableStatus->columns,
                        'indexes' => $tableStatus->indexes,
                        'foreignKeys' => $tableStatus->foreign_keys,
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('schema')
                    ->placeholder('n/a')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('label')
                    ->searchable(),
                TextColumn::make('size')
                    ->formatStateUsing(fn (int $state) => Number::fileSize($state))
                    ->sortable()
                    ->alignEnd(),
                TextColumn::make('rows')
                    ->numeric()
                    ->sortable()
                    ->alignEnd(),
                TextColumn::make('engine')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'InnoDB' => Color::Green,
                        'MyISAM' => Color::Red,
                        default => Color::Gray,
                    })
                    ->placeholder('n/a'),
                TextColumn::make('collation')
                    ->placeholder('n/a'),
                TextColumn::make('comment')
                    ->placeholder('n/a'),
            ])
            ->defaultSort('table')
            ->filters([
                SelectFilter::make('engine')
                    ->options(
                        DatabaseRelation::query()
                            ->distinct('engine')
                            ->whereNotNull('engine')
                            ->pluck('engine', 'engine'),
                    ),
                SelectFilter::make('collation')
                    ->options(
                        DatabaseRelation::query()
                            ->whereNotNull('collation')
                            ->distinct('collation')
                            ->pluck('collation', 'collation'),
                    ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDatabaseRelations::route('/'),
            'view' => ViewDatabaseRelation::route('/{record}'),
        ];
    }
}
