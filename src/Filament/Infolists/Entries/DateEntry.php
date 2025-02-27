<?php

namespace BondarDe\Lox\Filament\Infolists\Entries;

use Carbon\Carbon;
use Filament\Infolists\Components\TextEntry;

class DateEntry extends TextEntry
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->formatStateUsing(
                fn (Carbon $state) => $state->diffForHumans(),
            )
            ->helperText(
                fn (Carbon $state) => $state->format('d.m.Y'),
            );
    }
}
