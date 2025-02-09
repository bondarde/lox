<?php

namespace BondarDe\Lox\Models;

use BondarDe\Lox\Constants\Cms\CmsTemplateVariableType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsTemplateVariable extends Model
{
    const string FIELD_ID = 'id';
    const string FIELD_CMS_TEMPLATE_ID = 'cms_template_id';

    const string FIELD_LABEL = 'label';
    const string FIELD_CONTENT_TYPE = 'content_type';

    const string REL_TEMPLATE = 'template';

    protected $fillable = [
        self::FIELD_CMS_TEMPLATE_ID,
        self::FIELD_LABEL,
        self::FIELD_CONTENT_TYPE,
    ];
    protected $casts = [
        self::FIELD_CONTENT_TYPE => CmsTemplateVariableType::class,
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(CmsTemplate::class);
    }
}
