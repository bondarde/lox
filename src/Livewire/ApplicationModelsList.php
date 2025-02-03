<?php

namespace BondarDe\Lox\Livewire;

use BondarDe\Lox\Constants\ModelCastTypes;
use BondarDe\Lox\Filament\Tables\Filters\MonthFilter;
use BondarDe\Lox\Filament\Tables\Filters\YearFilter;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class ApplicationModelsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public string $model;
    public string $dbTableName;

    #[Url]
    public ?array $tableFilters = null;
    #[Url]
    public $tableSearch = '';
    #[Url]
    public ?string $tableSortColumn = null;
    #[Url]
    public ?string $tableSortDirection = null;

    public function table(Table $table): Table
    {
        /** @var Model $model */
        $model = new $this->model();
        $dbTableColumns = DB::connection()->getSchemaBuilder()->getColumnListing($this->dbTableName);
        $toggleableColumns = [];
        $toggledHiddenByDefaultColumns = [];
        $casts = $model->getCasts();

        $defaultSortColumn = null;
        $defaultSortDirection = 'desc';

        $primaryKeyName = $model->getKeyName();
        if ($model->getKeyType() === 'int') {
            $defaultSortColumn = $primaryKeyName;
        }
        $toggleableColumns[] = $primaryKeyName;

        $columnsOrder = [
            $primaryKeyName,
        ];

        if ($model->usesTimestamps()) {
            $createdAtColumn = $model->getCreatedAtColumn();
            $updatedAtColumn = $model->getUpdatedAtColumn();

            $columnsOrder[] = $createdAtColumn;
            $columnsOrder[] = $updatedAtColumn;

            $toggleableColumns[] = $createdAtColumn;
            $toggleableColumns[] = $updatedAtColumn;

            $toggledHiddenByDefaultColumns[] = $updatedAtColumn;

            $casts = [
                $createdAtColumn => ModelCastTypes::DATETIME,
                $updatedAtColumn => ModelCastTypes::DATETIME,
                ...$casts,
            ];

            $defaultSortColumn = $createdAtColumn;
        }

        if (in_array(SoftDeletes::class, class_uses($model))) {
            $deletedAtColumn = $model->getDeletedAtColumn();
            $columnsOrder[] = $deletedAtColumn;

            $toggleableColumns[] = $deletedAtColumn;
            $toggledHiddenByDefaultColumns[] = $deletedAtColumn;

            $casts[$deletedAtColumn] ??= ModelCastTypes::DATETIME;
        }

        $dbTableColumns = self::sortColumns($dbTableColumns, $columnsOrder);

        $filters = self::makeFilters($dbTableColumns, $casts);

        return $table
            ->query($this->model::query())
            ->columns(
                collect($dbTableColumns)
                    ->map(
                        function (string $columnName) use ($casts, $toggleableColumns, $toggledHiddenByDefaultColumns): Column {
                            $cast = $casts[$columnName] ?? null;

                            $column = match ($cast) {
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
                                    ->wrap()
                                    ->lineClamp(3)
                                    ->searchable()
                                    ->placeholder('n/a'),
                            };

                            if (in_array($columnName, $toggleableColumns)) {
                                $column->toggleable(
                                    isToggledHiddenByDefault: in_array($columnName, $toggledHiddenByDefaultColumns),
                                );
                            }

                            return $column;
                        },
                    )
                    ->toArray(),
            )
            ->defaultSort($defaultSortColumn, $defaultSortDirection)
            ->filters($filters)
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    private static function sortColumns(array $columns, array $columnsOrder): array
    {
        $res = [];

        foreach ($columnsOrder as $column) {
            $res[] = $column;
        }

        foreach ($columns as $column) {
            if (in_array($column, $res)) {
                continue;
            }
            $res[] = $column;
        }

        return $res;
    }

    private static function makeFilters(array $dbTableColumns, array $casts): array
    {
        $filters = [];

        foreach ($dbTableColumns as $column) {
            $cast = $casts[$column] ?? null;
            if (
                $cast === ModelCastTypes::DATETIME
                || $cast === ModelCastTypes::DATE
                || $cast === ModelCastTypes::TIMESTAMP
            ) {
                $filters[] = YearFilter::make($column)
                    ->label($column . ': year');
                $filters[] = MonthFilter::make($column)
                    ->label($column . ': month');
            } elseif ($cast === ModelCastTypes::BOOLEAN) {
                $filters[] = TernaryFilter::make($column)
                    ->boolean()
                    ->label($column);
            }
        }

        return $filters;
    }

    public function render(): View
    {
        return view('lox::livewire.application-models-list');
    }
}
