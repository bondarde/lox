<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Filament\AdminPanel\Resources\CmsPageResource;
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

    public function parentFormOptions(?int $excludedId): array
    {
        $q = $this->query()
            ->orderBy(CmsPage::FIELD_PARENT_ID)
            ->orderBy(CmsPage::FIELD_ID);

        if ($excludedId) {
            $q->whereNot(CmsPage::FIELD_ID, $excludedId);
        }

        return $q
            ->get()
            ->keyBy(CmsPage::FIELD_ID)
            ->map(fn (CmsPage $cmsPage) => $cmsPage->{CmsPage::FIELD_PAGE_TITLE} . ' [' . $cmsPage->{CmsPage::FIELD_ID} . ']')
            ->prepend(__('No parent'), CmsPageResource::$defaultNoParentValue)
            ->toArray();
    }
}
