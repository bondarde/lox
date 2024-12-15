<?php

namespace BondarDe\Lox\Filament\AdminPanel\Pages;

use BondarDe\Lox\Models\Sushi\ScheduledCommand;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Schedule extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected ?string $heading = 'Schedule';
    protected ?string $subheading = 'Scheduled tasks with previous/last runs & details';

    protected static string $view = 'lox::admin.system.schedule';

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'System';

    public function table(Table $table): Table
    {
        return $table
            ->query(ScheduledCommand::query())
            ->columns([
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('command')
                    ->description(fn (ScheduledCommand $record) => $record->description)
                    ->copyable(),
                TextColumn::make('nextRun')
                    ->since()
                    ->dateTimeTooltip(),
                TextColumn::make('previousRun')
                    ->since()
                    ->dateTimeTooltip(),
                TextColumn::make('expression')
                    ->label('Schedule')
                    ->description(fn (ScheduledCommand $record) => $record->timezone),
                TextColumn::make('output')
                    ->copyable(),
            ])
            ->defaultSort('nextRun')
            ->filters([
                // ...
            ]);
    }
}
