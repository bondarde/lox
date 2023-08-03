<{{ $tag }} {{ $attributes->merge($buttonAttributes) }}>
@if($icon)
    <span class="font-bold">{!! $icon !!}</span>
@endif
<span>{{ $slot }}</span>
</{{ $tag }}>
