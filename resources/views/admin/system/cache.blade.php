<x-admin-page
    title="Cache"
    h1="Cache"
>

    <x-content class="inline-block">
        <table class="table">
            <thead>
            <tr>
                <th>File name: value</th>
                <th>Expires</th>
            </tr>
            </thead>
            @foreach($values as $value)
                <tr class="border-t">
                    <td>
                        <div>
                            {{ $value->filename }}:
                        </div>
                        <pre>{{ json_encode($value->value, JSON_PRETTY_PRINT) }}</pre>
                    </td>
                    <td>
                        {{ $value->expiresAt->diffForHumans() }}
                        <div class="text-sm opacity-50">
                            {{ $value->expiresAt }}
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </x-content>

</x-admin-page>
