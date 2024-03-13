<{{$tag}}
{{ $attributes->merge([
    'class' => "$padding $margin $background $shadow $rounded",
]) }}
>
{{ $slot }}
</{{$tag}}>
