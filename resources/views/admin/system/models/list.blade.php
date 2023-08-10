<x-admin-page
    :title="$modelMeta->className"
>

    <x-slot:header>
        <h1>
            <a
                class="hover:underline"
                href="{{ route('admin.system.models.index') }}"
            >Models</a>
        </h1>
        <div class="mb-8">
            {!! $modelMeta->htmlLabel() !!}
        </div>
    </x-slot:header>

    <livewire:live-model-list
        :model="$model"
    />

</x-admin-page>
