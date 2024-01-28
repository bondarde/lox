<?php

namespace BondarDe\Lox\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CmsTemplateVariableValue extends Model
{
    use HasTranslations;

    const ID = 'id';

    const FIELD_CMS_PAGE_ID = 'cms_page_id';
    const FIELD_CMS_TEMPLATE_VARIABLE_ID = 'cms_template_variable_id';

    const FIELD_CONTENT = 'content';

    protected $fillable = [
        self::FIELD_CMS_PAGE_ID,
        self::FIELD_CMS_TEMPLATE_VARIABLE_ID,
        self::FIELD_CONTENT,
    ];
    public array $translatable = [
        self::FIELD_CONTENT,
    ];
}
