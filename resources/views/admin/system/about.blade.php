<x-filament-panels::page>

    @foreach($systemStatus as $categoryName => $status)
        <x-filament::section
            :collapsible="true"
            :heading="ucfirst($categoryName)"
        >
            <table class="table">
                @foreach($status as $key => $value)
                    <tr @class([
                        'border-t' => !$loop->first,
                    ])>
                        <td>
                            {{ $key }}
                        </td>
                        <td>
                            @php
                                $json = '<pre>' . json_encode($value, JSON_PRETTY_PRINT) . '</pre>';
                            @endphp
                            @switch(gettype($value))
                                @case('string')
                                    @php
                                        $isSuccess = in_array($value, [
                                            'YES',
                                            'ENABLED',
                                            'PUBLISHED',
                                            'CACHED',
                                        ]);
                                        $isDanger = in_array($value, [
                                            'NO',
                                            'DISABLED',
                                            'NOT PUBLISHED',
                                            'NOT CACHED',
                                            'NOT SET',
                                            'MISSING DSN',
                                        ]);
                                    @endphp
                                    @if($isSuccess || $isDanger)
                                        <x-filament::badge
                                            class="inline-flex font-mono"
                                            color="{{ $isSuccess ? 'success' : 'danger' }}"
                                            icon="{{ $isSuccess ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle' }}"
                                        >
                                            {{ $value }}
                                        </x-filament::badge>
                                    @else
                                        {{ $value }}
                                    @endif
                                    @break
                                @case('boolean')
                                    <x-filament::badge
                                        class="inline-flex"
                                        color="{{ $value ? 'success' : 'danger' }}"
                                        icon="{{ $value ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle' }}"
                                    >
                                        {!! $json !!}
                                    </x-filament::badge>
                                    @break
                                @case('NULL')
                                    <x-filament::badge
                                        class="inline-flex"
                                        color="info"
                                        icon="heroicon-o-no-symbol"
                                    >
                                        {!! $json !!}
                                    </x-filament::badge>
                                    @break
                                @default
                                    {!! $json !!}
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-filament::section>
    @endforeach

</x-filament-panels::page>
