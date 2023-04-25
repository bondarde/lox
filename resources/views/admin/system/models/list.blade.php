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

    <x-model-list
        :model="$model"
    >
        <table class="table">
            <thead>
            <tr>
                @foreach($attributes as $attribute)
                    <th>{{ $attribute }}</th>
                @endforeach
            </tr>
            </thead>
            @foreach($component->items as $item)
                <tr class="border-t">
                    @foreach($attributes as $attribute)
                        <td class="max-w-xs text-ellipsis overflow-hidden">
                            <a
                                href="{{ route('admin.system.models.details', [$model, $item->id]) }}"
                            >
                                @php
                                    echo match(gettype($item->{$attribute})){
                                        'string', 'integer' => $item->{$attribute},
                                        'NULL' => '<span class="opacity-50">null</span>',
                                        default => '<pre class="text-ellipsis overflow-hidden">' . json_encode($item->{$attribute}, JSON_PRETTY_PRINT) . '</pre>',
                                    };
                                @endphp
                            </a>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </x-model-list>

</x-admin-page>
