<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Models\CmsTemplate;

class CmsTemplateRepository extends ModelRepository
{
    public function model(): string
    {
        return CmsTemplate::class;
    }

    public function formOptions(): array
    {
        $res = [
            0 => 'No Template',
        ];

        $this->query()
            ->orderBy(CmsTemplate::FIELD_LABEL)
            ->get()
            ->each(function (CmsTemplate $cmsTemplate) use (&$res) {
                $id = $cmsTemplate->{CmsTemplate::FIELD_ID};
                $res[$id] = $cmsTemplate->{CmsTemplate::FIELD_LABEL}
                    . ' (' . $id . ')';
            });

        return $res;
    }
}
