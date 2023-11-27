<a
    {{ $attributes->merge([
        'class' => 'inline-block p-4 rounded-lg shadow hover:shadow-lg ' . $cssClasses,
        'href' => $href,
    ]) }}
>
    <div class="text-4xl text-right font-semibold mb-2">
        {!! $renderSlot($slot) !!}
    </div>
    <div class="opacity-75 text-right text-sm">
        {!! $label !!}
    </div>
</a>
