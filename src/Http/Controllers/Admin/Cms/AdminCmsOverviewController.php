<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Cms;

use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Lox\Repositories\CmsRedirectRepository;
use BondarDe\Lox\Repositories\CmsTemplateRepository;

class AdminCmsOverviewController
{
    public function __invoke(
        CmsPageRepository     $cmsPageRepository,
        CmsTemplateRepository $cmsTemplateRepository,
        CmsRedirectRepository $cmsRedirectRepository,
    )
    {
        $cmsPagesWithoutParent = $cmsPageRepository->withoutParents();
        $cmsPagesCount = $cmsPageRepository->count();
        $templatesCount = $cmsTemplateRepository->count();
        $redirectsCount = $cmsRedirectRepository->count();

        return view('lox::admin.cms.overview', compact(
            'cmsPagesWithoutParent',
            'cmsPagesCount',
            'templatesCount',
            'redirectsCount',
        ));
    }
}
