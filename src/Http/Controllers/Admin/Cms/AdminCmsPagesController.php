<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Cms;

use BondarDe\Lox\Http\Requests\Admin\Cms\CmsPageEditRequest;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;
use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Lox\Repositories\CmsTemplateVariableValueRepository;

class AdminCmsPagesController
{
    public function index(
        CmsPageRepository $cmsPageRepository,
    )
    {
        $cmsPagesWithoutParent = $cmsPageRepository->withoutParents();

        return view('lox::admin.cms.pages.index', compact(
            'cmsPagesWithoutParent',
        ));
    }

    public function create()
    {
        return view('lox::admin.cms.pages.create');
    }

    public function store(
        CmsPageEditRequest $request,
        CmsPageRepository  $cmsPageRepository,
    )
    {
        $attributes = $request->validated();

        if (!$attributes[CmsPage::FIELD_CMS_TEMPLATE_ID]) {
            unset($attributes[CmsPage::FIELD_CMS_TEMPLATE_ID]);
        }

        $cmsPage = $cmsPageRepository->create($attributes);

        return redirect(route('admin.cms-pages.show', $cmsPage))
            ->with('success-message', 'Seite erstellt');
    }

    public function show(CmsPage $cmsPage)
    {
        return view('lox::admin.cms.pages.show', compact(
            'cmsPage',
        ));
    }

    public function edit(CmsPage $cmsPage)
    {
        return view('lox::admin.cms.pages.edit', compact(
            'cmsPage',
        ));
    }

    public function update(
        CmsPage                            $cmsPage,
        CmsPageEditRequest                 $request,
        CmsPageRepository                  $cmsPageRepository,
        CmsTemplateVariableValueRepository $cmsTemplateVariableValueRepository,
    )
    {
        $attributes = $request->validated();
        if (!$attributes[CmsPage::FIELD_CMS_TEMPLATE_ID]) {
            unset($attributes[CmsPage::FIELD_CMS_TEMPLATE_ID]);
        }

        $cmsPageRepository->update($cmsPage, $attributes);

        $this->updateTemplateVariables($cmsPage, $request, $cmsTemplateVariableValueRepository);

        return redirect(route('admin.cms-pages.show', $cmsPage))
            ->with('success-message', 'Seite wurde aktualisiert');
    }

    private function updateTemplateVariables(
        CmsPage                            $cmsPage,
        CmsPageEditRequest                 $request,
        CmsTemplateVariableValueRepository $cmsTemplateVariableValueRepository,
    )
    {
        foreach ($cmsPage->{CmsPage::PROPERTY_TEMPLATE}?->{CmsTemplate::PROPERTY_TEMPLATE_VARIABLES} as $tv) {
            $requestFieldName = 'tv-' . $tv->{CmsTemplateVariable::FIELD_ID};

            $value = $request->string($requestFieldName);

            $cmsTemplateVariableValueRepository->setValue(
                $cmsPage,
                $tv,
                $value,
            );
        }
    }
}
