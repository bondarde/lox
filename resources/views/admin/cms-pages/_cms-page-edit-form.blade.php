<?php

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Repositories\CmsPageRepository;

$cmsPageRepository = app(CmsPageRepository::class);
$parents = $cmsPageRepository->parentsListForEditor();

?>
<div class="flex flex-col md:flex-row gap-8">
    <div class="md:w-2/3">

        <x-form.form-row
            :for="CmsPage::FIELD_PAGE_TITLE"
            label="Seitentitel"
        >
            <x-form.input
                :name="CmsPage::FIELD_PAGE_TITLE"
                :model="$model"
                label="Seitentitel"
                placeholder="Seitentitel"
            />
        </x-form.form-row>

        <x-form.form-row
            :for="CmsPage::FIELD_CONTENT"
            label="Inhalt"
        >
            <x-form.textarea
                :name="CmsPage::FIELD_CONTENT"
                :model="$model"
                label="Inhalt"
                placeholder="Inhalt"
            />
        </x-form.form-row>

    </div>
    <div class="md:w-1/3">

        <x-content class="flex flex-col gap-8">
            <h3>Einstellungen</h3>
            <div>
                <x-form.input
                    :name="CmsPage::FIELD_SLUG"
                    :model="$model"
                    label="Pfad"
                    placeholder="Pfad"
                    :show-errors="true"
                />
            </div>
            <div>
                <x-form.select
                    :name="CmsPage::FIELD_PARENT_ID"
                    :options="$parents"
                    :model="$model"
                    label="Parent"
                />
            </div>
            <div>
                <x-form.boolean
                    :name="CmsPage::FIELD_IS_PUBLIC"
                    :model="$model"
                >
                    {{ __('Public') }}
                </x-form.boolean>
            </div>
            <div>
                <x-form.boolean
                    :name="CmsPage::FIELD_IS_INDEX"
                    :model="$model"
                >
                    {{ __('Index') }}
                </x-form.boolean>
            </div>
            <div>
                <x-form.boolean
                    :name="CmsPage::FIELD_IS_FOLLOW"
                    :model="$model"
                >
                    {{ __('Follow') }}
                </x-form.boolean>
            </div>
        </x-content>

    </div>
</div>


<x-form.tiny-mce
    selector="textarea[name={{ CmsPage::FIELD_CONTENT }}]"
/>
