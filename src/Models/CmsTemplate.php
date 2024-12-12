<?php

namespace BondarDe\Lox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsTemplate extends Model
{
    const string FIELD_ID = 'id';

    const string FIELD_LABEL = 'label';
    const string FIELD_CONTENT = 'content';

    const string REL_TEMPLATE_VARIABLES = 'template_variables';
    const string REL_PAGES = 'cms_pages';

    const string COUNT_TEMPLATE_VARIABLES = 'template_variables_count';
    const string COUNT_PAGES = 'cms_pages_count';

    protected $fillable = [
        self::FIELD_LABEL,
        self::FIELD_CONTENT,
    ];
    protected $withCount = [
        self::REL_TEMPLATE_VARIABLES,
        self::REL_PAGES,
    ];

    public function template_variables(): HasMany
    {
        return $this->hasMany(CmsTemplateVariable::class);
    }

    public function cms_pages(): HasMany
    {
        return $this->hasMany(CmsPage::class);
    }
}
