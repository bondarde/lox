<?php

namespace BondarDe\Lox\Livewire\ModelList;

use BondarDe\Lox\Livewire\ModelList\Concerns\WithConfigurableColumns;
use BondarDe\Lox\Livewire\ModelList\Data\ColumnConfiguration;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Content extends Component
{
    #[Reactive]
    public Collection $items;

    #[Reactive]
    public string $pagination;

    #[Reactive]
    public string $searchQuery;

    public array $modelAttributes = [];
    private ?array $columnConfigs = null;

    private static function toModelAttributes(?array $columnConfigs, Model $firstItem)
    {
        if ($columnConfigs) {
            return collect($columnConfigs)
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

    private function renderItem(Model $item, string $key): View|string|null
    {
        $config = $this->columnConfigs[$key];

        if (is_string($config)) {
            // only column title is configured
            return $item->{$key};
        }

        /** @var ColumnConfiguration $config */
        $renderer = $config->render;

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

        if ($hasConfigurableColumns) {
            /** @var WithConfigurableColumns $firstItem */
            $this->columnConfigs = $firstItem->getModelListColumnConfigurations();
        }

        $this->modelAttributes = self::toModelAttributes($this->columnConfigs, $firstItem);

        $renderItem = fn(Model $item, string $key) => $this->renderItem($item, $key);

        return view('lox::livewire.model-list.content', compact(
            'renderItem',
        ));
    }
}
