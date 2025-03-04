<?php

namespace BondarDe\Lox\Filament\Tables\Columns;

use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;

class DateColumn extends TextColumn
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->formatStateUsing(
                fn (?Carbon $state) => $state?->diffForHumans(),
            )
            ->description(
                fn (?Carbon $state) => $state?->format('d.m.Y'),
            );
    }
}
