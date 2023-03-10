<x-admin-page
    title="Routes"
    h1="Routes"
>

    <p class="mb-2">
        {{ $routes->count() }} routes found:
    </p>

    <x-content class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>Path</th>
                <th>Methods</th>
                <th>Action</th>
                <th>Wheres</th>
            </tr>
            </thead>
            @foreach($routes as $route)
                <tr class="border-t">
                    <td>
                        {{ $route->uri }}
                    </td>
                    <td>
                        @foreach($route->methods as $method)
                            {{ $method }}
                        @endforeach
                    </td>
                    <td>
                        <table class="table">
                            @php
                                $firstRow = true;
                            @endphp
                            @foreach($route->action as $actionAttribute => $actionValue)
                                @if(!$actionValue)
                                    @continue
                                @endif
                                <tr @class(["border-t" => !$firstRow])>
                                    @php
                                        $firstRow = false;
                                    @endphp
                                    <td>
                                        {{ $actionAttribute }}
                                    </td>
                                    <td>
                                        @if(gettype($actionValue) === 'array')
                                            <ul>
                                                @foreach($actionValue as $item)
                                                    <li>
                                                        {{ $item }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @elseif($actionValue instanceof \Closure)
                                            <em>Closure</em>
                                        @else
                                            {{ $actionValue }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table>
                            @foreach($route->wheres as $placeholder => $pattern)
                                <tr @class(["border-t" => !$loop->first])>
                                    <td>
                                        {{ $placeholder }}
                                    </td>
                                    <td>
                                        {{ $pattern }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            @endforeach
        </table>
    </x-content>

</x-admin-page>
