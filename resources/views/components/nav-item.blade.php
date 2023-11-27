<li @class([$containerClass])>
    <a
        {{ $attributes->merge([
            'class' => $cssClasses,
        ]) }}
        href="{{ $href }}"
    >
        {{ $slot }}
        @if(!is_null($info))
            <small class="opacity-50">{!! $info !!}</small>
        @endif
    </a>
</li>
