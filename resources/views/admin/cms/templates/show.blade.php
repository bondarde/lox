<?php

use BondarDe\Lox\Models\CmsTemplate;

?>
<x-admin-page
    title="Template {{ $cmsTemplate->{CmsTemplate::FIELD_LABEL} }}"
>

    <div class="flex gap-8 justify-between mb-4">
        <h1>
            Template {{ $cmsTemplate->{CmsTemplate::FIELD_LABEL} }}
        </h1>
        <div>
            <x-button
                tag="a"
                :href="route('admin.cms-templates.edit', $cmsTemplate)"
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

</x-admin-page>
