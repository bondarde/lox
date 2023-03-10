<x-admin-page
    title="Events"
    h1="Events"
>

    <x-content class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>Event</th>
                <th>Listeners</th>
            </tr>
            </thead>
            @foreach($events as $event => $listeners)
                <tr class="border-t">
                    <td>
                        {{ $event }}
                    </td>
                    <td>
                        <ul>
                        @foreach($listeners as $listener)
                            <li>
                                {{ $listener }}
                            </li>
                        @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </table>
    </x-content>

</x-admin-page>
