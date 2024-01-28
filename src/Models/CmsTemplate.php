<?php

namespace BondarDe\Lox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsTemplate extends Model
{
    const FIELD_ID = 'id';

    const FIELD_LABEL = 'label';
    const FIELD_CONTENT = 'content';

    const PROPERTY_TEMPLATE_VARIABLES = 'template_variables';

    protected $fillable = [
        self::FIELD_LABEL,
        self::FIELD_CONTENT,
    ];

    public function template_variables(): HasMany
    {
        return $this->hasMany(CmsTemplateVariable::class);
    }
}
