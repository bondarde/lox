<x-admin-page
    title="About"
    h1="About"
>

    @foreach($systemStatus as $categoryName => $status)
        <h2>{{ ucfirst($categoryName) }}</h2>
        <x-content>
            <table class="table">
                @foreach($status as $key => $value)
                    <tr @class([
                        'border-t' => !$loop->first,
                    ])>
                        <td>
                            {{ $key }}
                        </td>
                        <td>
                            @switch(gettype($value))
                                @case('string')
                                    {{ $value }}
                                    @break
                                @default
                                    <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-content>
    @endforeach

</x-admin-page>
