<div {{ $attributes }}>
    <div>
        {{ now()->format('Y-m-d H:i:s') }}
        <br>
        App version:
        {{ config('app.version') }}
    </div>
    <div>
        Rendering time:
        <x-lox::number
            :number="$renderingTimeMs"
            suffix="ms"
        />
    </div>
    @if($dbQueriesTimeMs > -1)
        <div>
            DB time:
            <x-lox::number
                :number="$dbQueriesTimeMs"
                suffix="ms"
            />
        </div>
    @endif
    @if($dbQueriesCount > -1)
        <div>
            DB queries:
            <x-lox::number
                :number="$dbQueriesCount"
            />
        </div>
    @endif
    <div>
        Max memory:
        <x-lox::file-size
            :bytes="$memoryPeakUsageBytes"
        />
    </div>
</div>
