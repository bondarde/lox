<?php

use BondarDe\Lox\Models\CmsTemplate;

?>
<x-form.form-row
    :for="CmsTemplate::FIELD_LABEL"
    label="Name"
>

    <x-form.input
        :name="CmsTemplate::FIELD_LABEL"
        :model="$model"
    />

</x-form.form-row>


<x-form.form-row
    :for="CmsTemplate::FIELD_CONTENT"
    label="Template"
>

    <x-form.textarea
        :name="CmsTemplate::FIELD_CONTENT"
        :model="$model"
    />

</x-form.form-row>


<x-form.form-row
    :show-errors="false"
    label="Template Variables"
>
    @if($model)
        <livewire:cms.template-variables-editor
            :cms-template="$model"
        />
    @else
        <p>
            Save template to add template variables.
        </p>
    @endif
</x-form.form-row>
