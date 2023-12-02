<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Models\CmsRedirect;

class CmsRedirectRepository extends ModelRepository
{
    public function model(): string
    {
        return CmsRedirect::class;
    }

    public function getByPath(string $path): CmsRedirect
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->query()
            ->where(CmsRedirect::FIELD_PATH, $path)
            ->sole();
    }

    public function createOrUpdate(string $path, string $target): CmsRedirect
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->query()
            ->updateOrCreate([
                CmsRedirect::FIELD_PATH => $path,
            ], [
                CmsRedirect::FIELD_TARGET => $target,
            ]);
    }
}
