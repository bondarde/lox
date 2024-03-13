<?php

use BondarDe\Lox\Models\CmsAssistantTask;

?>
<x-admin-page>

    <h2>
        {{ __('New Task') }}
    </h2>

    <x-validation-errors
        class="mb-8"
    />

    <form
        method="post"
        action="{{ route('admin.cms.pages.assistant.store') }}"
    >
        @csrf
        @method('PUT')

        <x-form.form-row
            :for="CmsAssistantTask::FIELD_TASK"
            :label="__('Task')"
        >
            <x-form.input
                :name="CmsAssistantTask::FIELD_TASK"
                :placeholder="__('Task')"
                :value="old(CmsAssistantTask::FIELD_TASK, config('lox.cms.assistant.default_task'))"
            />
        </x-form.form-row>

        <x-form.form-row
            :for="CmsAssistantTask::FIELD_TOPIC"
            :label="__('Topic')"
        >
            <x-form.input
                :name="CmsAssistantTask::FIELD_TOPIC"
                :placeholder="__('Topic')"
            />
        </x-form.form-row>

        <x-form.form-row
            :for="CmsAssistantTask::FIELD_LOCALE"
            :label="__('Locale')"
        >
            <x-form.input
                :name="CmsAssistantTask::FIELD_LOCALE"
                :placeholder="__('Locale')"
                :value="old(CmsAssistantTask::FIELD_LOCALE, config('app.locale'))"
            />
        </x-form.form-row>


        <x-form.form-actions>
            <x-button
                color="green"
                icon="+"
            >
                {{ __('Create') }}
            </x-button>
        </x-form.form-actions>
    </form>


    <h2>
        {{ __('Tasks') }}
    </h2>
    <livewire:live-model-list
        :model="\BondarDe\Lox\Models\CmsAssistantTask::class"
    />

</x-admin-page>
