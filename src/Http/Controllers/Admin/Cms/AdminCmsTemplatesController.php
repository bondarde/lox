<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Cms;

use BondarDe\Lox\Http\Requests\Admin\Cms\CmsTemplateEditRequest;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Repositories\CmsTemplateRepository;

class AdminCmsTemplatesController
{
    public function index(
        CmsTemplateRepository $cmsTemplateRepository,
    )
    {
        $cmsTemplates = $cmsTemplateRepository->all();

        return view('lox::admin.cms.templates.index', compact(
            'cmsTemplates',
        ));
    }

    public function create()
    {
        return view('lox::admin.cms.templates.create');
    }

    public function store(
        CmsTemplateEditRequest $request,
        CmsTemplateRepository  $cmsTemplateRepository,
    )
    {
        $attributes = $request->validated();
        $cmsTemplate = $cmsTemplateRepository->create($attributes);

        return redirect(route('admin.cms.templates.show', $cmsTemplate))
            ->with('success-message', 'Template created.');
    }

    public function show(CmsTemplate $cmsTemplate)
    {
        return view('lox::admin.cms.templates.show', compact(
            'cmsTemplate',
        ));
    }

    public function edit(CmsTemplate $cmsTemplate)
    {
        return view('lox::admin.cms.templates.edit', compact(
            'cmsTemplate',
        ));
    }

    public function update(
        CmsTemplate            $cmsTemplate,
        CmsTemplateEditRequest $request,
        CmsTemplateRepository  $cmsTemplateRepository,
    )
    {
        $attributes = $request->validated();

        $cmsTemplateRepository->update($cmsTemplate, $attributes);

        return redirect(route('admin.cms.templates.show', $cmsTemplate))
            ->with('success-message', 'Template updated.');
    }
}
