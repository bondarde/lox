<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Models\CmsPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CmsPageRepository extends ModelRepository
{
    public function model(): string
    {
        return CmsPage::class;
    }

    public function byPath(string $path): Builder
    {
        return $this->query()
            ->where(CmsPage::FIELD_PATH, $path);
    }

    public function withoutParents(): Collection
    {
        return $this->query()
            ->whereNull(CmsPage::FIELD_PARENT_ID)
            ->get();
    }

    public function parentsListForEditor(): array
    {
        $res = [
            0 => __('No parent'),
        ];

        $pages = $this->query()
            ->orderBy(CmsPage::FIELD_PARENT_ID)
            ->orderBy(CmsPage::FIELD_ID)
            ->get()
            ->keyBy(CmsPage::FIELD_ID)
            ->map(fn(CmsPage $cmsPage) => $cmsPage->{CmsPage::FIELD_PAGE_TITLE} . ' [' . $cmsPage->{CmsPage::FIELD_ID} . ']')
            ->toArray();
        foreach ($pages as $id => $label) {
            $res[$id] = $label;
        }

        return $res;
    }
}
