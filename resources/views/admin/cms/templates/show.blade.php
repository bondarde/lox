<?php

use BondarDe\Lox\Models\CmsPage;
use BondarDe\Lox\Models\CmsTemplate;

?>
<x-admin-page
    title="Template {{ $cmsTemplate->{CmsTemplate::FIELD_LABEL} }}"
>

    <div class="flex gap-8 justify-between mb-4">
        <h1>
            <div class="text-xs opacity-65 mb-0">
                Template
            </div>
            {{ $cmsTemplate->{CmsTemplate::FIELD_LABEL} }}
        </h1>
        <div>
            <x-button
                tag="a"
                :href="route('admin.cms.templates.edit', $cmsTemplate)"
                icon="📝"
            >
                Edit template
            </x-button>
        </div>
    </div>

    <x-content class="overflow-x-scroll">
        <pre
            class=""
        >{{ $cmsTemplate->{CmsTemplate::FIELD_CONTENT} }}</pre>
    </x-content>

    <h2>
        Pages
    </h2>

    @if($cmsTemplate->{CmsTemplate::REL_PAGES}->isNotEmpty())
        <p class="opacity-65">
            Pages using this template
        </p>

        <x-content>
            <table class="table">
                <thead>
                <tr>
                    <th>Page Title</th>
                    <th>Path</th>
                </tr>
                </thead>
                @foreach($cmsTemplate->{CmsTemplate::REL_PAGES} as $cmsPage)
                    <tr class="border-t">
                        <td>
                            <a
                                class="underline hover:no-underline"
                                href="{{ route('admin.cms.pages.show', $cmsPage) }}"
                            >
                                {{ $cmsPage->{CmsPage::FIELD_PAGE_TITLE} }}
                            </a>
                        </td>
                        <td>
                            <a
                                class="hover:underline"
                                href="{{ url($cmsPage->{CmsPage::FIELD_PATH}) }}"
                            >
                                {{ $cmsPage->{CmsPage::FIELD_PATH} }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-content>
    @else
        <p class="my-4 opacity-65">
            No CMS pages use this template.
        </p>
    @endif

</x-admin-page>
