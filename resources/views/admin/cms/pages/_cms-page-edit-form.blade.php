<?php

use BondarDe\Lox\Constants\Cms\CmsTemplateVariableType;
use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;
use BondarDe\Lox\Repositories\CmsPageRepository;
use BondarDe\Lox\Repositories\CmsTemplateRepository;

$cmsPageRepository = app(CmsPageRepository::class);
$cmsTemplateRepository = app(CmsTemplateRepository::class);
$parents = $cmsPageRepository->parentsListForEditor();

$templates = $cmsTemplateRepository->formOptions();

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
            :for="CmsPage::FIELD_CMS_TEMPLATE_ID"
            label="Template"
        >
            <x-form.select
                :name="CmsPage::FIELD_CMS_TEMPLATE_ID"
                :options="$templates"
                :value="old(CmsPage::FIELD_CMS_TEMPLATE_ID, $model?->{CmsPage::FIELD_CMS_TEMPLATE_ID} ?: 0)"
            />
        </x-form.form-row>


        @foreach($cmsPage->{CmsPage::PROPERTY_TEMPLATE}?->{CmsTemplate::PROPERTY_TEMPLATE_VARIABLES} ?? [] as $tv)
            <x-form.form-row
                :for="CmsPage::FIELD_CONTENT"
                :label="$tv->{CmsTemplateVariable::FIELD_LABEL}"
            >
                @switch($tv->{CmsTemplateVariable::FIELD_CONTENT_TYPE})
                    @case(CmsTemplateVariableType::Html)
                        <x-form.textarea
                            name="tv-{{ $tv->id }}"
                            :value="old('tv-' . $tv->id, $cmsPage->cmsTemplateVariableValue($tv))"
                            placeholder="{{ $tv->{CmsTemplateVariable::FIELD_LABEL} }}"
                        />
                        @break
                    @case(CmsTemplateVariableType::PlainText)
                        <x-form.textarea
                            name="tv-{{ $tv->id }}"
                            :value="old('tv-' . $tv->id, $cmsPage->cmsTemplateVariableValue($tv))"
                            placeholder="{{ $tv->{CmsTemplateVariable::FIELD_LABEL} }}"
                        />
                        @break
                    @case(CmsTemplateVariableType::Media)
                        Media …
                        @break
                @endswitch
            </x-form.form-row>

        @endforeach


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
