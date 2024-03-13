<?php

namespace BondarDe\Lox\Support;

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

class CmsRenderer
{
    public static function renderCmsPageContent(CmsPage $cmsPage): string
    {
        if ($cmsPage->{CmsPage::FIELD_CMS_TEMPLATE_ID}) {
            return self::renderCmsPageWithTemplate($cmsPage);
        }

        return self::renderCmsPageWithoutTemplate($cmsPage);
    }

    public static function renderCmsPageWithTemplate(CmsPage $cmsPage): string
    {
        $cmsTemplate = $cmsPage->{CmsPage::REL_TEMPLATE};

        /** @var Collection $tvs */
        $tvs = $cmsTemplate->{CmsTemplate::REL_TEMPLATE_VARIABLES};
        $tvsContent = $tvs->mapWithKeys(fn(CmsTemplateVariable $tv) => [
            $tv->{CmsTemplateVariable::FIELD_LABEL} => $cmsPage->cmsTemplateVariableValue($tv),
        ]);

        $template = $cmsTemplate->{CmsTemplate::FIELD_CONTENT};
        $data = [
            'content' => $cmsPage->{CmsPage::FIELD_CONTENT},
            ...$tvsContent,
        ];

        return Blade::render($template, $data);
    }

    public static function renderCmsPageWithoutTemplate(CmsPage $cmsPage): string
    {
        return Blade::render('
            <x-content class="prose dark:prose-invert">
                {!! $content !!}
            </x-content>
        ', [
            'content' => $cmsPage->{CmsPage::FIELD_CONTENT},
        ]);
    }
}
