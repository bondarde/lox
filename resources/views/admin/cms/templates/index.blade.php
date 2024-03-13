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
            <table class="table">
                <thead>
                <tr>
                    <th>Template</th>
                    <th>Pages</th>
                </tr>
                </thead>
                @foreach($cmsTemplates as $cmsTemplate)
                    <tr class="border-t">
                        <td>
                            <a
                                class="underline hover:no-underline"
                                href="{{ route('admin.cms-templates.show', $cmsTemplate) }}"
                            >
                                {{ $cmsTemplate->{CmsTemplate::FIELD_LABEL} }}
                            </a>
                        </td>
                        <td class="text-right">
                            <x-number
                                :number="$cmsTemplate->{CmsTemplate::REL_PAGES}->count()"
                            />
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-content>
    @else
        <p>
            No templates found.
        </p>
    @endif

</x-admin-page>
