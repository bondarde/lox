<x-admin-page
    :title="$pageTitle"
>

    <x-slot:header>
        <h1>Models</h1>
        <div class="mb-8">
            <a
                class="hover:underline"
                href="{{ route('admin.system.models.list', $model) }}"
            >{!! $modelMeta->htmlLabel() !!}</a>
            {{ $id }}
        </div>
    </x-slot:header>

    <x-model-meta
        :model="$modelInstance"
    />

</x-admin-page>
