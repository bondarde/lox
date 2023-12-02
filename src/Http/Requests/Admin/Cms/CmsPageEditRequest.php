<?php

namespace BondarDe\Lox\Http\Requests\Admin\Cms;

use BondarDe\Lox\Constants\ValidationRules;
use BondarDe\Lox\Models\CmsPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CmsPageEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CmsPage::FIELD_SLUG => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_STRING,
            ],

            CmsPage::FIELD_PAGE_TITLE => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_STRING,
                Rule::requiredIf(fn() => !$this->get(CmsPage::FIELD_SLUG)),
            ],

            CmsPage::FIELD_CONTENT => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_STRING,
            ],

            CmsPage::FIELD_H1_TITLE => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_STRING,
            ],

            CmsPage::FIELD_PARENT_ID => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_INTEGER,
            ],

            CmsPage::FIELD_META_DESCRIPTION => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_STRING,
            ],

            CmsPage::FIELD_IS_PUBLIC => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_BOOLEAN,
            ],

            CmsPage::FIELD_IS_INDEX => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_BOOLEAN,
            ],

            CmsPage::FIELD_IS_FOLLOW => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_BOOLEAN,
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            CmsPage::FIELD_IS_PUBLIC => $this->boolean(CmsPage::FIELD_IS_PUBLIC),
            CmsPage::FIELD_IS_INDEX => $this->boolean(CmsPage::FIELD_IS_INDEX),
            CmsPage::FIELD_IS_FOLLOW => $this->boolean(CmsPage::FIELD_IS_FOLLOW),
            CmsPage::FIELD_PARENT_ID => $this->get(CmsPage::FIELD_PARENT_ID) ?: null,
        ]);
    }
}
