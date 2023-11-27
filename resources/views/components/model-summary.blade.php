<x-content class="prose">
    @foreach($attributeNames as $attributeName)
        <h4>{{ $renderName($attributeName) }}</h4>
        <div class="mb-8">
            {!! $renderValue($attributeName) !!}
        </div>
    @endforeach
</x-content>
