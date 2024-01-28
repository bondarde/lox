<?php

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;

?>
<x-admin-page
    :title="$cmsPage->{CmsPage::FIELD_PAGE_TITLE}"
>
    <x-slot:header>
        <div class="flex">
            <div class="grow">
                <h1 class="mb-0">
                    {{ $cmsPage->{CmsPage::FIELD_PAGE_TITLE} }}
                </h1>
                <a
                    class="opacity-50 hover:opacity-100 hover:underline"
                    href="/{{ $cmsPage->{CmsPage::FIELD_PATH} }}"
                    target="_blank"
                >
                    {{ $cmsPage->{CmsPage::FIELD_PATH} }}
                </a>
            </div>

            <div>
                <x-button
                    tag="a"
                    :href="route('admin.cms-pages.edit', $cmsPage)"
                    icon="📝"
                >
                    {{ __('Edit page') }}
                </x-button>
            </div>
        </div>
    </x-slot:header>


    <div class="flex flex-col md:flex-row gap-8">
        <x-content class="md:w-2/3">
            @foreach($cmsPage->{CmsPage::PROPERTY_TEMPLATE}?->{CmsTemplate::PROPERTY_TEMPLATE_VARIABLES} ?? [] as $tv)
                <h3 class="opacity-75">
                    {{ $tv->{CmsTemplateVariable::FIELD_LABEL} }}
                </h3>

                {!! $cmsPage->cmsTemplateVariableValue($tv) ?: '<p class="opacity-50">n/a</p>' !!}
            @endforeach
            <h3 class="opacity-75">Content</h3>
            <div class="prose md:w-2/3">
                {!! $cmsPage->{CmsPage::FIELD_CONTENT} !!}
            </div>
        </x-content>

        <div class="md:w-1/3">
            <x-content>
                <table class="table">
                    <tr>
                        <td>
                            {{ __('Created') }}:
                        </td>
                        <td>
                            <x-relative-timestamp
                                :model="$cmsPage"
                                :attr="CmsPage::FIELD_CREATED_AT"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ __('Updated') }}:
                        </td>
                        <td>
                            <x-relative-timestamp
                                :model="$cmsPage"
                                :attr="CmsPage::FIELD_UPDATED_AT"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>{{ __('Public') }}:</td>
                        <td>{{ $cmsPage->{CmsPage::FIELD_IS_PUBLIC} ? '✅' : '❌' }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Index') }}:</td>
                        <td>{{ $cmsPage->{CmsPage::FIELD_IS_INDEX} ? '✅' : '❌' }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Follow') }}:</td>
                        <td>{{ $cmsPage->{CmsPage::FIELD_IS_FOLLOW} ? '✅' : '❌' }}</td>
                    </tr>
                </table>
            </x-content>

            @if($cmsPage->{CmsPage::PROPERTY_PARENT})
                <x-content class="mb-4">
                    <div>
                        Parent:
                    </div>
                    <a
                        class="link"
                        href="{{ route('admin.cms-pages.show', $cmsPage->{CmsPage::PROPERTY_PARENT}) }}"
                    >
                        {{ $cmsPage->{CmsPage::PROPERTY_PARENT}->{CmsPage::FIELD_PAGE_TITLE} }}
                    </a>
                </x-content>
            @endif
            @if($cmsPage->{CmsPage::PROPERTY_CHILDREN}->count())
                <x-content class="mb-4">
                    <div>
                        Children:
                    </div>
                    <ul class="flex flex-col gap-2">
                        @foreach($cmsPage->{CmsPage::PROPERTY_CHILDREN} as $childPage)
                            <li>
                                <a
                                    class="link"
                                    href="{{ route('admin.cms-pages.show', $childPage) }}"
                                >
                                    {{ $childPage->{CmsPage::FIELD_PAGE_TITLE} }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </x-content>
            @endif
        </div>
    </div>

</x-admin-page>
