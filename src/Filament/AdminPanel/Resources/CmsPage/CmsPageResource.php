<?php

namespace BondarDe\Lox\Filament\AdminPanel\Resources\CmsPage;

use BondarDe\Lox\Constants\Cms\CmsTemplateVariableType;
use BondarDe\Lox\Filament\HasModelCountNavigationBadge;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;
use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Lox\Repositories\CmsTemplateRepository;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Grid as FormGrid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section as FormSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Grid as InfolistGrid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CmsPageResource extends Resource
{
    use HasModelCountNavigationBadge;
    use Translatable;

    public static string $defaultNoParentValue = 'none';
    public static string $defaultNoTemplateValue = 'none';
    public static string $tvFieldNamePrefix = 'tv-';

    protected static ?string $model = CmsPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 100;

    public static function infolist(Infolist $infolist): Infolist
    {
        $currentCmsPage = $infolist->getRecord();
        $templateVariables = $currentCmsPage->{CmsPage::REL_TEMPLATE}?->{CmsTemplate::REL_TEMPLATE_VARIABLES} ?? collect();

        return $infolist->schema([
            InfolistGrid::make(3)->schema([

                InfolistGrid::make(1)->schema([
                    InfolistSection::make()
                        ->heading(__('lox::lox.admin.cms.pages.general_heading'))
                        ->description(__('lox::lox.admin.cms.pages.general_description'))
                        ->columns(2)
                        ->schema([
                            TextEntry::make(CmsPage::FIELD_PAGE_TITLE)
                                ->placeholder('n/a')
                                ->label(__('lox::lox.admin.cms.pages.page_title')),

                            TextEntry::make(CmsPage::FIELD_SLUG)
                                ->placeholder('n/a')
                                ->label(__('lox::lox.admin.cms.pages.slug_field')),

                        ]),
                    InfolistSection::make()
                        ->heading(__('lox::lox.admin.cms.pages.seo_heading'))
                        ->description(__('lox::lox.admin.cms.pages.seo_description'))
                        ->columns(2)
                        ->schema([
                            TextEntry::make(CmsPage::FIELD_H1_TITLE)
                                ->placeholder('n/a')
                                ->label(__('lox::lox.admin.cms.pages.h1_title')),
                            TextEntry::make(CmsPage::FIELD_MENU_TITLE)
                                ->placeholder('n/a')
                                ->label(__('lox::lox.admin.cms.pages.menu_title')),
                            TextEntry::make(CmsPage::FIELD_META_DESCRIPTION)
                                ->placeholder('n/a')
                                ->label(__('lox::lox.admin.cms.pages.meta_description')),
                            TextEntry::make(CmsPage::FIELD_CANONICAL)
                                ->placeholder('n/a')
                                ->label(__('lox::lox.admin.cms.pages.canonical')),
                        ]),
                ])->columnSpan(2),

                InfolistSection::make()
                    ->heading(__('lox::lox.admin.cms.pages.settings_heading'))
                    ->description(__('lox::lox.admin.cms.pages.settings_description'))
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make(CmsPage::REL_PARENT . '.' . CmsPage::FIELD_PAGE_TITLE)
                            ->url(
                                fn (CmsPage $record) => $record->{CmsPage::REL_PARENT}
                                ? CmsPageResource::getUrl('view', [$record->{CmsPage::REL_PARENT}])
                                : null,
                            )
                            ->placeholder('n/a')
                            ->label(__('lox::lox.admin.cms.pages.parent_page')),

                        TextEntry::make(CmsPage::REL_TEMPLATE . '.' . CmsTemplate::FIELD_LABEL)
                            ->placeholder('n/a')
                            ->label(__('lox::lox.admin.cms.pages.template')),

                        IconEntry::make(CmsPage::FIELD_IS_PUBLIC)
                            ->boolean()
                            ->label(mb_ucfirst(__('lox::lox.admin.cms.pages.published'))),

                        IconEntry::make(CmsPage::FIELD_IS_INDEX)
                            ->boolean()
                            ->label('Meta: index'),

                        IconEntry::make(CmsPage::FIELD_IS_FOLLOW)
                            ->boolean()
                            ->label('Meta: follow'),

                        TextEntry::make(CmsPage::FIELD_PATH)
                            ->url(
                                fn (string $state) => '/' . $state,
                            )
                            ->openUrlInNewTab()
                            ->label(__('lox::lox.admin.cms.pages.full_path')),
                    ]),

            ]),

            InfolistSection::make()
                ->heading(__('lox::lox.admin.cms.pages.contents_heading'))
                ->description(__('lox::lox.admin.cms.pages.contents_description'))
                ->schema([
                    TextEntry::make(CmsPage::FIELD_CONTENT)
                        ->placeholder('n/a')
                        ->label(__('lox::lox.admin.cms.pages.main_content')),

                    ...$templateVariables->map(function (CmsTemplateVariable $tv): TextEntry {
                        $name = $tv->{CmsTemplateVariable::FIELD_LABEL};
                        $fieldName = self::$tvFieldNamePrefix . $tv->{CmsTemplateVariable::FIELD_ID};
                        $label = '$' . $name;

                        return match ($tv->{CmsTemplateVariable::FIELD_CONTENT_TYPE}) {
                            CmsTemplateVariableType::PlainText,
                            CmsTemplateVariableType::Html => TextEntry::make($fieldName)
                                ->label($label),
                        };
                    })->toArray(),
                ]),
        ]);
    }

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
                FormGrid::make(3)->schema([

                    FormGrid::make(1)
                        ->columnSpan(2)
                        ->schema([

                            FormSection::make()
                                ->heading(__('lox::lox.admin.cms.pages.general_heading'))
                                ->description(__('lox::lox.admin.cms.pages.general_description'))
                                ->schema([
                                    TextInput::make(CmsPage::FIELD_PAGE_TITLE)
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (?string $state, Get $get, Set $set) {
                                            $currentSlugValue = $get(CmsPage::FIELD_SLUG);

                                            if (! empty($state) && empty($currentSlugValue)) {
                                                $slug = Str::slug($state, language: config('app.locale'));
                                                $set(CmsPage::FIELD_SLUG, $slug);
                                            }
                                        })
                                        ->label(__('lox::lox.admin.cms.pages.page_title')),

                                    TextInput::make(CmsPage::FIELD_SLUG)
                                        ->label('URL slug')
                                        ->required()
                                        ->label(__('lox::lox.admin.cms.pages.slug_field')),

                                ]),

                            FormSection::make()
                                ->heading(__('lox::lox.admin.cms.pages.seo_heading'))
                                ->description(__('lox::lox.admin.cms.pages.seo_description'))
                                ->columns(1)
                                ->schema([
                                    TextInput::make(CmsPage::FIELD_H1_TITLE)
                                        ->label(__('lox::lox.admin.cms.pages.h1_title')),
                                    TextInput::make(CmsPage::FIELD_MENU_TITLE)
                                        ->label(__('lox::lox.admin.cms.pages.menu_title')),
                                    TextInput::make(CmsPage::FIELD_META_DESCRIPTION)
                                        ->label(__('lox::lox.admin.cms.pages.meta_description')),
                                    TextInput::make(CmsPage::FIELD_CANONICAL)
                                        ->label(__('lox::lox.admin.cms.pages.canonical')),
                                ]),
                        ]),

                    FormSection::make()
                        ->heading(__('lox::lox.admin.cms.pages.settings_heading'))
                        ->description(__('lox::lox.admin.cms.pages.settings_description'))
                        ->columnSpan(1)
                        ->schema([
                            Select::make(CmsPage::FIELD_PARENT_ID)
                                ->label(__('lox::lox.admin.cms.pages.parent_page'))
                                ->options($parents)
                                ->default(self::$defaultNoParentValue)
                                ->selectablePlaceholder(false)
                                ->required(),

                            Select::make(CmsPage::FIELD_CMS_TEMPLATE_ID)
                                ->label(__('lox::lox.admin.cms.pages.template'))
                                ->options($templates)
                                ->default(self::$defaultNoTemplateValue)
                                ->selectablePlaceholder(false)
                                ->required(),

                            Toggle::make(CmsPage::FIELD_IS_PUBLIC)
                                ->label(mb_ucfirst(__('lox::lox.admin.cms.pages.published'))),
                            Toggle::make(CmsPage::FIELD_IS_INDEX)
                                ->default(true)
                                ->label('Meta: index'),
                            Toggle::make(CmsPage::FIELD_IS_FOLLOW)
                                ->default(true)
                                ->label('Meta: follow'),

                            Placeholder::make(CmsPage::FIELD_PATH)
                                ->content(
                                    fn (?CmsPage $record) => $record
                                        ? new HtmlString(
                                            '<a href="/' . $record->{CmsPage::FIELD_PATH} . '" target="_blank">'
                                            . $record->{CmsPage::FIELD_PATH}
                                            . '</a>',
                                        )
                                        : 'n/a',
                                )
                                ->label(__('lox::lox.admin.cms.pages.full_path')),
                        ]),

                ]),

                FormSection::make()
                    ->heading(__('lox::lox.admin.cms.pages.contents_heading'))
                    ->description(__('lox::lox.admin.cms.pages.contents_description'))
                    ->schema([
                        RichEditor::make(CmsPage::FIELD_CONTENT)
                            ->label(__('lox::lox.admin.cms.pages.main_content'))
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
                    ->label(
                        __('lox::lox.admin.cms.pages.label')
                        . ', '
                        . __('lox::lox.admin.cms.pages.full_path'),
                    )
                    ->description(fn (CmsPage $record) => $record->{CmsPage::FIELD_PATH})
                    ->placeholder('n/a')
                    ->searchable(),
                TextColumn::make(CmsPage::REL_PARENT . '.' . CmsPage::FIELD_PAGE_TITLE)
                    ->placeholder('n/a')
                    ->searchable()
                    ->label(__('lox::lox.admin.cms.pages.parent_page')),

                TextColumn::make('text_length')
                    ->state(fn (CmsPage $cmsPage) => Str::wordCount(strip_tags($cmsPage->{CmsPage::FIELD_CONTENT})) . ' words')
                    ->description(fn (CmsPage $cmsPage) => mb_strlen(strip_tags($cmsPage->{CmsPage::FIELD_CONTENT})) . ' chars')
                    ->label('Length'),

                TextColumn::make(CmsPage::REL_TEMPLATE . '.' . CmsTemplate::FIELD_LABEL)
                    ->placeholder('n/a')
                    ->searchable()
                    ->label(__('lox::lox.admin.cms.pages.template')),

                IconColumn::make(CmsPage::FIELD_IS_PUBLIC)
                    ->boolean()
                    ->alignCenter()
                    ->label(ucfirst(__('lox::lox.admin.cms.pages.published'))),
                IconColumn::make(CmsPage::FIELD_IS_INDEX)
                    ->boolean()
                    ->alignCenter()
                    ->label('Index'),
                IconColumn::make(CmsPage::FIELD_IS_FOLLOW)
                    ->boolean()
                    ->alignCenter()
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

    public static function getNavigationGroup(): ?string
    {
        return __('lox::lox.admin.cms.navigation_group_name');
    }

    public static function getSlug(): string
    {
        return __('lox::lox.admin.cms.pages.slug');
    }

    public static function getLabel(): string
    {
        return __('lox::lox.admin.cms.pages.label');
    }

    public static function getPluralLabel(): string
    {
        return __('lox::lox.admin.cms.pages.plural_label');
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
