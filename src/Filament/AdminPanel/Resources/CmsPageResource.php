<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources;

use BondarDe\Lox\Constants\Cms\CmsTemplateVariableType;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPageResource\Pages;
use BondarDe\Lox\Filament\HasModelCountNavigationBadge;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;
use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Lox\Repositories\CmsTemplateRepository;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CmsPageResource extends Resource
{
    use HasModelCountNavigationBadge;
    use Translatable;

    public static string $defaultNoParentValue = 'none';
    public static string $defaultNoTemplateValue = 'none';
    public static string $tvFieldNamePrefix = 'tv-';

    protected static ?string $model = CmsPage::class;
    protected static ?string $slug = 'cms-pages';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'CMS';
    protected static ?int $navigationSort = 100;

    protected static ?string $label = 'Page';
    protected static ?string $pluralLabel = 'Pages';

    public static function form(Form $form): Form
    {
        $cmsPageRepository = app(CmsPageRepository::class);
        $cmsTemplateRepository = app(CmsTemplateRepository::class);

        $templates = $cmsTemplateRepository->formOptions();

        $currentCmsPage = $form->getRecord();
        $parents = $cmsPageRepository->parentFormOptions($currentCmsPage?->{CmsPage::FIELD_ID});

        $templateVariables = $currentCmsPage->{CmsPage::REL_TEMPLATE}?->{CmsTemplate::REL_TEMPLATE_VARIABLES} ?? collect();

        return $form
            ->schema([
                Grid::make()->schema([
                    Section::make([
                        TextInput::make(CmsPage::FIELD_PAGE_TITLE)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, Get $get, Set $set) {
                                $currentSlugValue = $get(CmsPage::FIELD_SLUG);

                                if (! empty($state) && empty($currentSlugValue)) {
                                    $slug = Str::slug($state, language: config('app.locale'));
                                    $set(CmsPage::FIELD_SLUG, $slug);
                                }
                            }),

                        TextInput::make(CmsPage::FIELD_SLUG)
                            ->label('URL slug')
                            ->required(),

                        Fieldset::make('SEO')
                            ->columns(1)
                            ->schema([
                                TextInput::make(CmsPage::FIELD_H1_TITLE),
                                TextInput::make(CmsPage::FIELD_MENU_TITLE),
                                TextInput::make(CmsPage::FIELD_META_DESCRIPTION),
                                TextInput::make(CmsPage::FIELD_CANONICAL),
                            ]),

                    ])
                        ->columnSpan(2),

                    Section::make([
                        Select::make(CmsPage::FIELD_PARENT_ID)
                            ->label('Parent page')
                            ->options($parents)
                            ->default(self::$defaultNoParentValue)
                            ->selectablePlaceholder(false)
                            ->required(),

                        Select::make(CmsPage::FIELD_CMS_TEMPLATE_ID)
                            ->label('Template')
                            ->options($templates)
                            ->default(self::$defaultNoTemplateValue)
                            ->selectablePlaceholder(false)
                            ->required(),

                        Toggle::make(CmsPage::FIELD_IS_PUBLIC)
                            ->label('Published'),
                        Toggle::make(CmsPage::FIELD_IS_INDEX)
                            ->default(true)
                            ->label('Meta: index'),
                        Toggle::make(CmsPage::FIELD_IS_FOLLOW)
                            ->default(true)
                            ->label('Meta: follow'),

                        Placeholder::make(CmsPage::FIELD_PATH)
                            ->content(fn (?CmsPage $record) => $record?->{CmsPage::FIELD_PATH} ?: 'n/a'),
                    ])
                        ->columnSpan(1),
                ])
                    ->columns(3),

                Section::make(
                    'Contents',
                )->schema([
                    RichEditor::make(CmsPage::FIELD_CONTENT)
                        ->label('Main Content')
                        ->columnSpanFull(),
                    ...$templateVariables->map(function (CmsTemplateVariable $tv): Field {
                        $name = $tv->{CmsTemplateVariable::FIELD_LABEL};
                        $fieldName = self::$tvFieldNamePrefix . $tv->{CmsTemplateVariable::FIELD_ID};
                        $label = '$' . $name;

                        return match ($tv->{CmsTemplateVariable::FIELD_CONTENT_TYPE}) {
                            CmsTemplateVariableType::PlainText => Textarea::make($fieldName)
                                ->label($label),
                            CmsTemplateVariableType::Html => RichEditor::make($fieldName)
                                ->label($label),
                        };
                    })->toArray(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(CmsPage::FIELD_CREATED_AT)
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make(CmsPage::FIELD_UPDATED_AT)
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make(CmsPage::FIELD_PAGE_TITLE)
                    ->label('Page, URL')
                    ->description(fn (CmsPage $record) => $record->{CmsPage::FIELD_PATH})
                    ->placeholder('n/a')
                    ->searchable(),
                TextColumn::make(CmsPage::REL_PARENT . '.' . CmsPage::FIELD_PAGE_TITLE)
                    ->placeholder('n/a')
                    ->searchable(),

                TextColumn::make('text_length')
                    ->state(fn (CmsPage $cmsPage) => Str::wordCount(strip_tags($cmsPage->{CmsPage::FIELD_CONTENT})) . ' words')
                    ->description(fn (CmsPage $cmsPage) => mb_strlen(strip_tags($cmsPage->{CmsPage::FIELD_CONTENT})) . ' chars')
                    ->label('Length'),

                TextColumn::make(CmsPage::REL_TEMPLATE . '.' . CmsTemplate::FIELD_LABEL)
                    ->placeholder('n/a')
                    ->searchable(),

                IconColumn::make(CmsPage::FIELD_IS_PUBLIC)
                    ->boolean()
                    ->label('Public'),
                IconColumn::make(CmsPage::FIELD_IS_INDEX)
                    ->boolean()
                    ->label('Index'),
                IconColumn::make(CmsPage::FIELD_IS_FOLLOW)
                    ->boolean()
                    ->label('Follow'),
            ])
            ->defaultSort(CmsPage::FIELD_UPDATED_AT, 'desc')
            ->filters([
                TernaryFilter::make(CmsPage::FIELD_IS_PUBLIC)
                    ->boolean()
                    ->label('Published'),
                TernaryFilter::make(CmsPage::FIELD_IS_INDEX)
                    ->boolean()
                    ->label('Meta: index'),
                TernaryFilter::make(CmsPage::FIELD_IS_FOLLOW)
                    ->boolean()
                    ->label('Meta: follow'),
                TernaryFilter::make(CmsPage::FIELD_CMS_TEMPLATE_ID)
                    ->nullable()
                    ->label('Template'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCmsPages::route('/'),
            'create' => Pages\CreateCmsPage::route('/create'),
            'view' => Pages\ViewCmsPage::route('/{record}'),
            'edit' => Pages\EditCmsPage::route('/{record}/edit'),
        ];
    }
}
