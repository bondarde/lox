<?php

namespace BondarDe\Lox\Filament\AdminPanel\Infolists\Components;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Component;
use Filament\Infolists\Components\Entry;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class ModelsListEntry extends Entry implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected string $view = 'lox::filament.admin.infolists.components.models-list-entry';
}
