<?php

namespace BondarDe\Lox\Repositories;

use BondarDe\Lox\Database\ModelRepository;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplateVariable;
use BondarDe\Lox\Models\CmsTemplateVariableValue;

class CmsTemplateVariableValueRepository extends ModelRepository
{
    public function model(): string
    {
        return CmsTemplateVariableValue::class;
    }

    public function findByCmsPageAndCmsTemplateVariableId(
        CmsPage             $cmsPage,
        CmsTemplateVariable $cmsTemplateVariable,
    ): ?CmsTemplateVariableValue
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->query()
            ->where(CmsTemplateVariableValue::FIELD_CMS_PAGE_ID, $cmsPage->{CmsPage::FIELD_ID})
            ->where(CmsTemplateVariableValue::FIELD_CMS_TEMPLATE_VARIABLE_ID, $cmsTemplateVariable->{CmsTemplateVariable::FIELD_ID})
            ->first();
    }

    public function setValue(
        CmsPage             $cmsPage,
        CmsTemplateVariable $cmsTemplateVariable,
        ?string             $value,
    ): void
    {
        $this->query()
            ->updateOrCreate([
                CmsTemplateVariableValue::FIELD_CMS_PAGE_ID => $cmsPage->{CmsPage::FIELD_ID},
                CmsTemplateVariableValue::FIELD_CMS_TEMPLATE_VARIABLE_ID => $cmsTemplateVariable->{CmsTemplateVariable::FIELD_ID},
            ], [
                CmsTemplateVariableValue::FIELD_CONTENT => $value,
            ]);
    }
}
