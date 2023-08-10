<div class="overflow-x-auto">
    <table
        class="table w-full"
    >
        <thead class="bg-gray-100 dark:bg-gray-800">
        <tr>
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
            <tr class="border-t" wire:key="{{ $item->id }}">
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
                <td
                    class="pl-4 pr-4 pt-0 pb-0"
                    colspan="{{ count($modelAttributes) }}"
                >
                    {!! $pagination !!}
                </td>
            </tr>
            </tfoot>
        @endif
    </table>
</div>
