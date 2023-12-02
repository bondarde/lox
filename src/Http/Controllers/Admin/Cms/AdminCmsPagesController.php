<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Cms;

use BondarDe\Lox\Http\Requests\Admin\Cms\CmsPageEditRequest;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Repositories\CmsPageRepository;

class AdminCmsPagesController
{
    public function index(
        CmsPageRepository $cmsPageRepository,
    )
    {
        $cmsPagesWithoutParent = $cmsPageRepository->withoutParents();

        return view('lox::admin.cms-pages.index', compact(
            'cmsPagesWithoutParent',
        ));
    }

    public function create()
    {
        return view('lox::admin.cms-pages.create');
    }

    public function store(
        CmsPageEditRequest $request,
        CmsPageRepository  $cmsPageRepository,
    )
    {
        $attributes = $request->validated();
        $cmsPage = $cmsPageRepository->create($attributes);

        return redirect(route('admin.cms-pages.show', $cmsPage))
            ->with('success-message', 'Seite erstellt');
    }

    public function show(CmsPage $cmsPage)
    {
        return view('lox::admin.cms-pages.show', compact(
            'cmsPage',
        ));
    }

    public function edit(CmsPage $cmsPage)
    {
        return view('lox::admin.cms-pages.edit', compact(
            'cmsPage',
        ));
    }

    public function update(
        CmsPage            $cmsPage,
        CmsPageEditRequest $request,
        CmsPageRepository  $cmsPageRepository,
    )
    {
        $attributes = $request->validated();

        $cmsPageRepository->update($cmsPage, $attributes);

        return redirect(route('admin.cms-pages.show', $cmsPage))
            ->with('success-message', 'Seite wurde aktualisiert');
    }
}
