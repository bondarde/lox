<?php

namespace BondarDe\Lox\Livewire\ModelList;

use BondarDe\Lox\Livewire\ModelList\Columns\ColumnConfigurations;
use BondarDe\Lox\Livewire\ModelList\Concerns\WithConfigurableColumns;
use BondarDe\Lox\Livewire\ModelList\Data\ColumnConfiguration;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Content extends Component
{
    public Collection $items;
    public ?string $pagination;
    public string $searchQuery;
    public bool $isActionPanelVisible;

    #[Reactive]
    public array $bulkActionPrimaryKeys;

    public array $modelAttributes = [];
    private ?array $columnConfigs = null;

    private static function toModelAttributes(?array $columnConfigs, Model $firstItem): array
    {
        if ($columnConfigs) {
            return collect($columnConfigs)
                ->filter()
                ->mapWithKeys(fn(ColumnConfiguration|string $config, $key) => [
                    $key => match (is_string($config)) {
                        true => $config,
                        default => $config->label,
                    },
                ])
                ->toArray();
        }

        return collect($firstItem->getAttributes())
            ->keys()
            ->mapWithKeys(fn(string $key) => [
                $key => ColumnConfiguration::toLabel($key),
            ])
            ->toArray();
    }

    private function renderItem(Model $item, string $key, ?string $searchQuery): View|string|null
    {
        $config = $this->columnConfigs[$key];

        if (is_string($config)) {
            // only column title is configured
            return ColumnConfigurations::render($item, $key, $searchQuery);
        }

        /** @var ColumnConfiguration $config */
        $renderer = $config->render;

        if (!$renderer) {
            return null;
        }

        return $renderer($item, $this->searchQuery);
    }

    public function render(): View
    {
        if ($this->items->isEmpty()) {
            return view('lox::livewire.model-list.empty');
        }

        /** @var Model $firstItem */
        $firstItem = $this->items->get(0);

        $hasConfigurableColumns = is_subclass_of($firstItem, WithConfigurableColumns::class);

        /** @var Model&WithConfigurableColumns $firstItem */
        $this->columnConfigs = match ($hasConfigurableColumns) {
            true => $firstItem->getModelListColumnConfigurations()::all(),
            default => collect($firstItem->getAttributes())
                ->keys()
                ->mapWithKeys(fn(string $key) => [
                    $key => ucfirst($key),
                ])
                ->toArray(),
        };

        $this->modelAttributes = self::toModelAttributes($this->columnConfigs, $firstItem);

        $renderItem = fn(Model $item, string $key) => $this->renderItem($item, $key, $this->searchQuery);

        return view('lox::livewire.model-list.content', compact(
            'renderItem',
        ));
    }
}
