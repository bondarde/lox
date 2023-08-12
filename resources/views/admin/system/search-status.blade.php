<?php

use BondarDe\Lox\Http\Controllers\Admin\System\Data\SearchIndexStatus;
use BondarDe\Lox\Http\Controllers\Admin\System\Data\ModelMeta;

?>
<x-admin-page
    title="Search Status"
    h1="Search Status"
>

    <x-content class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>Model</th>
                <th>Index</th>
                <th>Index Columns</th>
                <th>DB Records</th>
                <th>Index Records</th>
                <th>&Delta;</th>
            </tr>
            </thead>
            @foreach($statusRows as $row)
                @php
                    /** @var SearchIndexStatus $row */
                @endphp
                <tr class="border-t">
                    <td>
                        <a
                            class="hover:underline"
                            href="{{ route('admin.system.models.list', $row->className) }}"
                        >
                            {!! ModelMeta::fromFullyQualifiedClassName($row->className) !!}
                        </a>
                    </td>
                    <td>
                        {{ $row->indexName }}
                    </td>
                    <td>
                        <ul>
                            @foreach($row->indexColumns as $column)
                                <li>{{ $column }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-right">
                        <x-number
                            :number="$row->dbRowsCount"
                        />
                    </td>
                    <td class="text-right">
                        <x-number
                            :number="$row->indexedRowsCount"
                        />
                    </td>
                    <td @class([
                        'text-right pr-2',
                        'text-red-600 bg-red-50' => $row->delta,
                    ])>
                        <x-number
                            :number="$row->delta"
                        />
                    </td>
                </tr>
            @endforeach
        </table>
    </x-content>

</x-admin-page>
