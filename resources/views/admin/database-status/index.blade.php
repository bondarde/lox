<x-admin-page
    title="Database Status"
    h1="Database Status"
>

    <h2>Database</h2>
    <x-content class="overflow-x-auto">
        <p>
            Driver: {{ $databaseStatus->platform->config->driver }}
            <br>
            Database: {{ $databaseStatus->platform->config->database }}
            <br>
            Charset: {{ $databaseStatus->platform->config->charset }}
            <br>
            Collation: {{ $databaseStatus->platform->config->collation }}
            <br>
            Connections: {{ $databaseStatus->platform->open_connections }}
            <br>
            Tables size:
            <x-file-size
                :bytes="$tableSizeSum"
            />
        </p>
    </x-content>


    <h2>Tables</h2>
    <x-content class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>Table</th>
                <th class="text-right">Size</th>
                <th class="text-right">Rows</th>
                <th>Engine</th>
                <th>Comment</th>
            </tr>
            </thead>
            @foreach(collect($databaseStatus->tables)->sortBy('table') as $table)
                <tr class="border-t">
                    <td>
                        <a
                            class="hover:underline"
                            href="{{ route('admin.database-status.table', $table->table) }}"
                        >
                            {{ $table->table }}
                        </a>
                    </td>
                    <td class="text-right">
                        <x-file-size
                            :bytes="$table->size"
                        />
                    </td>
                    <td class="text-right">
                        <x-number
                            :number="$table->rows"
                        />
                    </td>
                    <td>{{ $table->engine }}</td>
                    <td>{{ $table->comment }}</td>
                </tr>
            @endforeach
        </table>
    </x-content>

    <h2
        class="mt-8"
    >Views</h2>
    @if($views)
        <x-content class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>View</th>
                    <th>Rows</th>
                </tr>
                </thead>
                @foreach($views as $view)
                    <tr class="border-t">
                        <td>
                            {{ $view->view }}
                        </td>
                        <td>
                            <x-number
                                :number="$view->rows"
                            />
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-content>
    @else
        <p class="opacity-50">
            No views found.
        </p>
    @endif

</x-admin-page>
