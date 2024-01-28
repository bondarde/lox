<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Models\CmsTemplateVariable;

class CmsTemplateVariableRepository extends ModelRepository
{
    public function model(): string
    {
        return CmsTemplateVariable::class;
    }
}
