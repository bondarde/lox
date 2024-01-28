<?php

use BondarDe\Lox\Constants\Cms\CmsTemplateVariableType;
use BondarDe\Lox\Models\CmsTemplate;
use BondarDe\Lox\Models\CmsTemplateVariable;

?>
<div>

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
        </thead>

        @foreach($cmsTemplate->{CmsTemplate::PROPERTY_TEMPLATE_VARIABLES} as $tv)
            <tr class="border-t">
                <td>
                    ${{ $tv->{CmsTemplateVariable::FIELD_LABEL} }}
                </td>
                <td>
                    {{ $tv->{CmsTemplateVariable::FIELD_CONTENT_TYPE}->name }}
                </td>
                <td>
                    <x-button
                        type="button"
                        size="sm"
                        icon="📝"
                    >
                        Edit
                    </x-button>
                </td>
            </tr>
        @endforeach


        @if(!$isAddingTemplateVariable)
            <tr class="border-t">
                <td colspan="2">
                </td>
                <td>
                    <x-button
                        type="button"
                        size="sm"
                        color="green"
                        icon="+"
                        wire:click="$toggle('isAddingTemplateVariable')"
                    >
                        Add Template Variable
                    </x-button>

                </td>
            </tr>
        @endif


        @if($isAddingTemplateVariable)

            <tr class="border-t">
                <td>
                    <x-form.input
                        name="new-tv-label"
                        wire:model.live.debounce.250ms="newTvLabel"
                        placeholder="Template Variable Name"
                    />
                </td>
                <td>
                    <x-form.select
                        name="new-tv-type"
                        wire:model.live="newTvType"
                        :options="CmsTemplateVariableType::formOptions()"
                    />
                </td>
                <td>
                    <x-button
                        class="mb-4"
                        type="button"
                        color="green"
                        icon="+"
                        wire:click="createTv()"
                    >
                        Add
                    </x-button>
                    <br>
                    <x-button
                        type="button"
                        size="sm"
                        color="red"
                        wire:click="$toggle('isAddingTemplateVariable')"
                    >
                        Cancel
                    </x-button>
                </td>
            </tr>

        @endif

    </table>
</div>
