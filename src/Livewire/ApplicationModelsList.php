<?php

namespace BondarDe\Lox\Livewire;

use BondarDe\Lox\Constants\ModelCastTypes;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class ApplicationModelsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public string $model;
    public string $dbTableName;

    public function table(Table $table): Table
    {
        /** @var Model $model */
        $model = new $this->model();
        $dbTableColumns = DB::connection()->getSchemaBuilder()->getColumnListing($this->dbTableName);
        $casts = $model->getCasts();

        $defaultSortColumn = null;
        $defaultSortDirection = 'desc';

        $primaryKeyName = $model->getKeyName();
        if ($model->getKeyType() === 'int') {
            $defaultSortColumn = $primaryKeyName;
        }

        if ($model->usesTimestamps()) {
            $casts = [
                $model->getCreatedAtColumn() => ModelCastTypes::DATETIME,
                $model->getUpdatedAtColumn() => ModelCastTypes::DATETIME,
                ...$casts,
            ];

            $defaultSortColumn = $model->getCreatedAtColumn();
        }

        return $table
            ->query($this->model::query())
            ->columns(
                collect($dbTableColumns)
                    ->map(
                        function (string $columnName) use ($casts): Column {
                            $cast = $casts[$columnName] ?? null;

                            return match ($cast) {
                                ModelCastTypes::FLOAT,
                                ModelCastTypes::DECIMAL,
                                ModelCastTypes::INTEGER => TextColumn::make($columnName)
                                    ->numeric(),
                                ModelCastTypes::DATE,
                                ModelCastTypes::TIMESTAMP,
                                ModelCastTypes::DATETIME => TextColumn::make($columnName)
                                    ->description(fn (?Carbon $state) => $state?->diffForHumans())
                                    ->dateTime()
                                    ->sortable()
                                    ->placeholder('n/a'),
                                ModelCastTypes::BOOLEAN => IconColumn::make($columnName)
                                    ->boolean(),
                                default => TextColumn::make($columnName)
                                    ->searchable()
                                    ->placeholder('n/a'),
                            };
                        },
                    )
                    ->toArray(),
            )
            ->defaultSort($defaultSortColumn, $defaultSortDirection)
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('lox::livewire.application-models-list');
    }
}
