<x-filament-panels::page>

    <div>

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
                                @php
                                    $json = '<pre>' . json_encode($value, JSON_PRETTY_PRINT) . '</pre>';
                                @endphp
                                @switch(gettype($value))
                                    @case('string')
                                        @php
                                            $isSuccess = in_array($value, [
                                                'ENABLED',
                                                'PUBLISHED',
                                                'CACHED',
                                            ]);
                                            $isDanger = in_array($value, [
                                                'DISABLED',
                                                'NOT PUBLISHED',
                                                'NOT CACHED',
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
                                        .:.:.[{{ gettype($value) }}]
                                        {!! $json !!}
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </table>
            </x-content>
        @endforeach

    </div>

</x-filament-panels::page>
