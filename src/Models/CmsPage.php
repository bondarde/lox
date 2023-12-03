<?php

namespace BondarDe\Lox\Models;

use BondarDe\Lox\Constants\ModelCastTypes;
use BondarDe\Lox\Exceptions\IllegalStateException;
use BondarDe\Lox\Livewire\ModelList\Concerns\WithConfigurableColumns;
use BondarDe\Lox\Models\Columns\CmsPageColumns;
use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Lox\Repositories\CmsRedirectRepository;
use BondarDe\Lox\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Translatable\HasTranslations;

class CmsPage extends Model implements WithConfigurableColumns
{
    use SoftDeletes;
    use Searchable;
    use HasTranslations;
    use CreatedUpdatedBy;

    const FIELD_ID = 'id';
    const FIELD_CREATED_AT = self::CREATED_AT;
    const FIELD_UPDATED_AT = self::UPDATED_AT;

    const FIELD_PARENT_ID = 'parent_id';
    const FIELD_PATH = 'path';
    const FIELD_SLUG = 'slug';

    const FIELD_PAGE_TITLE = 'page_title';
    const FIELD_MENU_TITLE = 'menu_title';
    const FIELD_CONTENT = 'content';

    const FIELD_H1_TITLE = 'h1_title';
    const FIELD_META_DESCRIPTION = 'meta_description';
    const FIELD_CANONICAL = 'canonical';

    const FIELD_IS_PUBLIC = 'is_public';
    const FIELD_IS_INDEX = 'is_index';
    const FIELD_IS_FOLLOW = 'is_follow';

    const PROPERTY_PARENT = 'parent';
    const PROPERTY_CHILDREN = 'children';

    protected $perPage = 100;

    protected $fillable = [
        self::FIELD_PARENT_ID,
        self::FIELD_PATH,
        self::FIELD_SLUG,
        self::FIELD_PAGE_TITLE,
        self::FIELD_MENU_TITLE,
        self::FIELD_CONTENT,
        self::FIELD_H1_TITLE,
        self::FIELD_META_DESCRIPTION,
        self::FIELD_CANONICAL,
        self::FIELD_IS_PUBLIC,
        self::FIELD_IS_INDEX,
        self::FIELD_IS_FOLLOW,
    ];
    protected $casts = [
        self::FIELD_PARENT_ID => ModelCastTypes::INTEGER,
        self::FIELD_IS_PUBLIC => ModelCastTypes::BOOLEAN,
        self::FIELD_IS_INDEX => ModelCastTypes::BOOLEAN,
        self::FIELD_IS_FOLLOW => ModelCastTypes::BOOLEAN,
    ];

    public array $translatable = [
        self::FIELD_PAGE_TITLE,
        self::FIELD_MENU_TITLE,
        self::FIELD_CONTENT,
        self::FIELD_H1_TITLE,
        self::FIELD_META_DESCRIPTION,
    ];

    protected static function booted(): void
    {
        parent::boot();

        $updateSlug = function (CmsPage $cmsPage) {
            $dirtyFields = $cmsPage->getDirty();

            if (
                !isset($dirtyFields[CmsPage::FIELD_SLUG])
                &&
                !isset($dirtyFields[CmsPage::FIELD_PAGE_TITLE])
            ) {
                throw new IllegalStateException('Page title or slug is required');
            }

            if (!isset($dirtyFields[CmsPage::FIELD_SLUG])) {
                $title = $cmsPage->{CmsPage::FIELD_PAGE_TITLE};
                $cmsPage->{self::FIELD_SLUG} = Str::slug($title);
            }

            $parent = $cmsPage->{self::PROPERTY_PARENT};
            $parentPrefix = match ($parent) {
                null => '',
                default => $parent->{self::FIELD_PATH} . '/',
            };
            $path = $parentPrefix . $cmsPage->{self::FIELD_SLUG};

            $cmsPage->{self::FIELD_PATH} = $path;
        };

        static::creating($updateSlug);
        static::updating(function (CmsPage $cmsPage) use ($updateSlug) {
            if ($cmsPage->{self::FIELD_SLUG}) {
                return;
            }

            $updateSlug($cmsPage);
        });

        static::updated(function (CmsPage $cmsPage) {
            $dirtyFields = $cmsPage->getDirty();
            if (
                !isset($dirtyFields[self::FIELD_SLUG])
                &&
                !isset($dirtyFields[self::FIELD_PATH])
                &&
                !array_key_exists(self::FIELD_PARENT_ID, $dirtyFields)
            ) {
                return;
            }

            /** @var CmsPageRepository $cmsPageRepository */
            $cmsPageRepository = app(CmsPageRepository::class);

            /** @var CmsRedirectRepository $cmsRedirectRepository */
            $cmsRedirectRepository = app(CmsRedirectRepository::class);

            /** @var ?self $parent */
            $parent = isset($dirtyFields[self::FIELD_PARENT_ID])
                ? $cmsPageRepository->find($dirtyFields[self::FIELD_PARENT_ID])
                : $cmsPage->{self::PROPERTY_PARENT};
            $parentPrefix = match ($parent) {
                null => '',
                default => $parent->{self::FIELD_PATH} . '/',
            };
            $path = $parentPrefix . $cmsPage->{self::FIELD_SLUG};
            $oldPath = $cmsPage->getOriginal(self::FIELD_PATH);

            $cmsPage->{self::FIELD_PATH} = $path;
            $cmsPage->saveQuietly();

            $cmsRedirectRepository->createOrUpdate($oldPath, $path);

            /** @var Collection $children */
            $children = $cmsPage->{self::PROPERTY_CHILDREN};

            $children->each(function (CmsPage $child) use ($cmsPageRepository, $path) {
                $cmsPageRepository->update($child, [
                    self::FIELD_PATH => $path . '/' . $child->{self::FIELD_SLUG},
                ]);
            });
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => strip_tags($this->{self::FIELD_ID}),
            ...$this->only($this->fillable),
            self::FIELD_CONTENT => strip_tags($this->{self::FIELD_CONTENT}),
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, self::FIELD_PARENT_ID);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, self::FIELD_PARENT_ID);
    }

    public static function getModelListColumnConfigurations(): ?string
    {
        return CmsPageColumns::class;
    }
}
