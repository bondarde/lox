<?php

namespace BondarDe\Lox\Http\Requests\Admin\Cms;

use BondarDe\Lox\Constants\ValidationRules;
use BondarDe\Lox\Models\CmsTemplate;
use Illuminate\Foundation\Http\FormRequest;

class CmsTemplateEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CmsTemplate::FIELD_LABEL => [
                ValidationRules::REQUIRED,
                ValidationRules::TYPE_STRING,
            ],

            CmsTemplate::FIELD_CONTENT => [
                ValidationRules::OPTIONAL,
                ValidationRules::TYPE_STRING,
            ],
        ];
    }
}
