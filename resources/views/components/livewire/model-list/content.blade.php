<div class="overflow-x-auto">
    <table
        class="table w-full"
    >
        <thead class="bg-gray-100 dark:bg-gray-800">
        <tr>
            @if($isActionPanelVisible)
                <th class="pl-4">⋯</th>
            @endif
            @foreach($modelAttributes as $key => $label)
                <th @class([
                    'pl-4' => $loop->first,
                    'pr-4' => $loop->last,
                ])>
                    {{ $label }}
                </th>
            @endforeach
        </tr>
        </thead>
        @foreach($items as $item)
            <tr
                @class([
                    'border-t',
                    'bg-indigo-100 dark:bg-indigo-900' => in_array($item->id, $bulkActionPrimaryKeys),
                ])
                wire:key="{{ $item->id }}"
            >
                @if($isActionPanelVisible)
                    <td class="pl-4 pt-4">
                        <div class="relative">
                            <input
                                class="absolute left-0"
                                type="checkbox"
                                @checked(in_array($item->id, $bulkActionPrimaryKeys))
                                onclick="return false"
                                wire:click="$parent.toggleBulkActionForId({{ $item->id }})"
                            >
                            <x-button
                                position="absolute"
                                padding=""
                                width="w-4 h-4"
                                class="left-0 opacity-0"
                                type="button"
                                wire:click="$parent.toggleBulkActionForId({{ $item->id }})"
                            ></x-button>
                        </div>
                    </td>
                @endif

                @foreach($modelAttributes as $key => $_)
                    <td @class([
                        'pl-4' => $loop->first,
                        'pr-4' => $loop->last,
                    ])>
                        {!! $renderItem($item, $key) !!}
                    </td>
                @endforeach
            </tr>
        @endforeach
        @if($pagination)
            <tfoot class="border-t-2">
            <tr>
            </tr>
            </tfoot>
        @endif
    </table>
    @if($pagination)
        <div class="px-4">
            {!! $pagination !!}
        </div>
    @endif
</div>
