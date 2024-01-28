<?php

use BondarDe\Lox\Models\CmsTemplate;

?>
<x-admin-page
    title="CMS Templates"
>

    <div class="flex justify-between gap-8 mb-4">
        <h1>CMS Templates</h1>
        <div>
            <x-button
                tag="a"
                :href="route('admin.cms-templates.create')"
                icon="+"
                color="green"
            >
                Create Template
            </x-button>
        </div>
    </div>


    @if($cmsTemplates->isNotEmpty())
        <x-content>
            <ul>
                @foreach($cmsTemplates as $cmsTemplate)
                    <li>
                        <a
                            href="{{ route('admin.cms-templates.show', $cmsTemplate) }}"
                        >
                            {{ $cmsTemplate->{CmsTemplate::FIELD_LABEL} }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-content>
    @else
        <p>
            No templates found.
        </p>
    @endif

</x-admin-page>
