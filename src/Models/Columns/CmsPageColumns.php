<?php

namespace BondarDe\Lox\Models\Columns;

use BondarDe\Lox\Livewire\ModelList\Columns\ColumnConfigurations;
use BondarDe\Lox\Livewire\ModelList\Data\ColumnConfiguration;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Utils\Html\DOM;
use Illuminate\Support\Str;

class CmsPageColumns extends ColumnConfigurations
{
    public static function all(): array
    {
        return [

            CmsPage::FIELD_PAGE_TITLE => new ColumnConfiguration(
                label: 'Title, Path',
                render: function (CmsPage $cmsPage, ?string $q): string {
                    $url = $cmsPage->{CmsPage::FIELD_PATH};

                    $pageTitleHighlighted = self::highlightSearchQuery($cmsPage->{CmsPage::FIELD_PAGE_TITLE}, $q);
                    $slugHighlighted = self::highlightSearchQuery($cmsPage->{CmsPage::FIELD_SLUG}, $q);
                    $urlHighlighted = self::highlightSearchQuery($url, $q);

                    $title = DOM::div([
                        'class' => 'underline group-hover:no-underline',
                    ], $pageTitleHighlighted);
                    $slug = DOM::div($slugHighlighted);

                    $link = DOM::a([
                        'class' => 'group',
                        'href' => route('admin.cms-pages.show', $cmsPage),
                    ], $title . $slug);

                    $publicLink = DOM::a([
                        'class' => 'hover:underline',
                        'href' => url($url),
                        'target' => '_blank',
                    ], $urlHighlighted);

                    $info = DOM::div([
                        'class' => 'mt-2 text-sm opacity-50 hover:opacity-100',
                    ], $publicLink);

                    return $link . $info;
                },
            ),

            CmsPage::FIELD_CONTENT => new ColumnConfiguration(
                label: 'Content',
                render: function (CmsPage $cmsPage, ?string $q): string {
                    $text = strip_tags($cmsPage->{CmsPage::FIELD_CONTENT});
                    $textLength = mb_strlen($text);
                    $wordsCount = Str::wordCount($text);

                    $wordsCountLabel = '<span class="label ' . ($wordsCount > 100 ? 'label-success' : 'label-danger') . '">' . $wordsCount . ' words</span>';
                    $textLengthLabel = '<span class="text-sm opacity-75">' . $textLength . ' characters</span>';

                    $content = Str::substr($text, 0, 300);
                    $content = self::highlightSearchQuery($content, $q);
                    if ($textLength > 300) {
                        $content .= '…';
                    }

                    $content = DOM::div([
                        'class' => 'mt-2 line-clamp-3 max-w-xl',
                    ], $content);

                    return $wordsCountLabel . ' ' . $textLengthLabel . $content;
                },
            ),

            CmsPage::FIELD_PARENT_ID => new ColumnConfiguration(
                label: 'Parent',
                render: function (CmsPage $cmsPage, ?string $q): string {
                    if (!$cmsPage->{CmsPage::PROPERTY_PARENT}) {
                        return '—';
                    }

                    return DOM::a([
                        'href' => route('admin.cms-pages.show', $cmsPage->{CmsPage::PROPERTY_PARENT}),
                        'class' => 'link',
                    ], $cmsPage->{CmsPage::PROPERTY_PARENT}->{CmsPage::FIELD_PAGE_TITLE});
                },
            ),

            CmsPage::FIELD_IS_PUBLIC => new ColumnConfiguration(
                label: __('Public'),
                render: function (CmsPage $cmsPage): string {
                    return $cmsPage->{CmsPage::FIELD_IS_PUBLIC} ? '✅' : '❌';
                },
            ),

        ];
    }
}
