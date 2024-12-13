<?php

namespace BondarDe\Lox\Filament\AdminPanel\Pages;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\ModelMeta;
use BondarDe\Lox\Models\Sushi\ApplicationEvent;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class Events extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected ?string $heading = 'Events';
    protected ?string $subheading = 'Application events and their listeners';

    protected static string $view = 'lox::admin.system.events';

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'System';

    public function table(Table $table): Table
    {
        return $table
            ->query(ApplicationEvent::query())
            ->columns([
                TextColumn::make('event')
                    ->formatStateUsing(function (string $state): HtmlString {
                        $modelMeta = ModelMeta::fromFullyQualifiedClassName($state);

                        return new HtmlString(
                            '<span class="opacity-65">' . $modelMeta->namespace . '\</span>'
                            . '<span class="font-semibold">' . $modelMeta->className . '</span>',
                        );
                    }),
                TextColumn::make('listeners')
                    ->listWithLineBreaks(),
            ])
            ->defaultSort('event')
            ->filters([
                //
            ]);
    }
}
