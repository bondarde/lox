<?php

namespace BondarDe\Lox\Http\Controllers\Web;

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsRedirect;
use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Lox\Repositories\CmsRedirectRepository;

class CmsContentController
{
    public function __invoke(
        string                $path,
        CmsPageRepository     $cmsPageRepository,
        CmsRedirectRepository $cmsRedirectRepository,
    )
    {
        $cmsPage = $cmsPageRepository
            ->byPath($path)
            ->where(CmsPage::FIELD_IS_PUBLIC, true)
            ->first();

        if (!$cmsPage) {
            $cmsRedirect = $cmsRedirectRepository->getByPath($path);
            $target = $cmsRedirect->{CmsRedirect::FIELD_TARGET};

            return redirect($target);
        }

        $pageTitle = $cmsPage->{CmsPage::FIELD_PAGE_TITLE};
        $h1 = $cmsPage->{CmsPage::FIELD_H1_TITLE} ?: $pageTitle;
        $content = $cmsPage->{CmsPage::FIELD_CONTENT};
        $metaDescription = $cmsPage->{CmsPage::FIELD_META_DESCRIPTION} ?? $pageTitle;
        $metaRobots = implode(', ', [
            $cmsPage->{CmsPage::FIELD_IS_INDEX} ? 'index' : 'noindex',
            $cmsPage->{CmsPage::FIELD_IS_FOLLOW} ? 'follow' : 'nofollow',
        ]);
        $canonical = $cmsPage->{CmsPage::FIELD_CANONICAL}
            ?: url($cmsPage->{CmsPage::FIELD_PATH});

        $templateVariables = [];

        return view(
            'lox::web.cms-page',
            compact(
                'pageTitle',
                'h1',
                'metaDescription',
                'metaRobots',
                'canonical',
                'content',
                'cmsPage',
            ),
            $templateVariables,
        );
    }
}
