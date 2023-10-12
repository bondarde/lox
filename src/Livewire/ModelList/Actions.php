<?php

namespace BondarDe\Lox\Livewire\ModelList;

use BondarDe\Lox\Livewire\ModelList\Columns\ColumnConfigurations;
use BondarDe\Lox\Livewire\ModelList\Concerns\WithConfigurableColumns;
use BondarDe\Lox\Livewire\ModelList\Data\ModelBulkAction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Actions extends Component
{
    public string $model;
    public array $selectedPrimaryKeys;

    private function actions(): array
    {
        /** @var WithConfigurableColumns $model */
        $model = $this->model;

        /** @var ColumnConfigurations $columnConfigurations */
        $columnConfigurations = $model::getModelListColumnConfigurations();

        /** @var array<ModelBulkAction> $actions */
        $actions = $columnConfigurations::actions();

        return $actions;
    }

    public function performAction(int $idx): void
    {
        $action = $this->actions()[$idx];
        $callback = $action->action;

        $res = $callback($this->selectedPrimaryKeys);

        if ($res) {
            $this->js('alert("Done.")');
        } else {
            $this->js('alert("Done, no success received!")');
        }
    }

    public function render(): ?View
    {
        return view('lox::livewire.model-list.actions', [
            'actions' => $this->actions(),
        ]);
    }
}
