<div {{ $attributes }}>
    <div>
        {{ now()->format('Y-m-d H:i:s') }}
    </div>
    <div>
        Rendering time:
        <x-number
            :number="$renderingTimeMs"
            suffix="ms"
        />
    </div>
    @if($dbQueriesTimeMs > -1)
        <div>
            DB time:
            <x-number
                :number="$dbQueriesTimeMs"
                suffix="ms"
            />
        </div>
    @endif
    @if($dbQueriesCount > -1)
        <div>
            DB queries:
            <x-number
                :number="$dbQueriesCount"
            />
        </div>
    @endif
    <div>
        Max memory:
        <x-file-size
            :bytes="$memoryPeakUsageBytes"
        />
    </div>
</div>
