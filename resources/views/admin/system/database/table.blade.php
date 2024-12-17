<div>

    <h2
        class="mt-8"
    >Columns</h2>
    <x-content class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>Column</th>
                <th>Type</th>
                <th>Default</th>
            </tr>
            </thead>
            @foreach($columns as $column)
                <tr class="border-t">
                    <td>
                        {{ $column->column }}
                    </td>
                    <td>
                        {{ $column->type }}
                        <ul class="opacity-50">
                            @foreach($column->attributes as $attribute => $value)
                                @if($attribute === 'type')
                                    @continue
                                @endif
                                <li>
                                    {{  $value }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        {{ $column->default ?? '—' }}
                    </td>
                </tr>
            @endforeach
        </table>
    </x-content>


    <h2
        class="mt-8"
    >Indexes</h2>
    @if($indexes)
        <x-content class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>Index</th>
                    <th>Columns</th>
                    <th>Attributes</th>
                </tr>
                </thead>
                @foreach($indexes as  $index)
                    <tr class="border-t">
                        <td>
                            {{ $index->name }}
                        </td>
                        <td>
                            <ul>
                                @foreach($index->columns as $column)
                                    <li>
                                        {{ $column }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($index->attributes as $attribute)
                                    <li>
                                        {{ $attribute }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-content>
    @else
        <p class="opacity-50">
            No indexes found.
        </p>
    @endif


    <h2
        class="mt-8"
    >Foreign Keys</h2>
    @if($foreignKeys)
        <x-content class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>Foreign Key</th>
                    <th>Columns</th>
                    <th>Foreign Table</th>
                    <th>Foreign Columns</th>
                    <th>On Update</th>
                    <th>On Delete</th>
                </tr>
                </thead>
                @foreach($foreignKeys as $foreignKey)
                    <tr class="border-t">
                        <td>
                            {{ $foreignKey->name }}
                        </td>
                        <td>
                            <ul>
                                @foreach($foreignKey->columns as $column)
                                    <li>
                                        {{ $column }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <a
                                class="underline hover:no-underline"
                                href="{{ route('filament.admin.resources.database.view', 'table:'.$foreignKey->foreign_table) }}"
                            >
                                {{ $foreignKey->foreign_table }}
                            </a>
                        </td>
                        <td>
                            @foreach($foreignKey->foreign_columns as $column)
                                {{ $column }}
                            @endforeach
                        </td>
                        <td>
                            {{ $foreignKey->on_update ?: '—' }}
                        </td>
                        <td>
                            {{ $foreignKey->on_delete ?: '—' }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-content>
    @else
        <p class="opacity-50">
            No foreign keys found.
        </p>
    @endif

</div>
