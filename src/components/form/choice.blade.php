@if($showErrors)
    <x-form.input-error
        for="{{ $name }}"
        class="mb-2"
    />
@endif


@if($label)
    <label
        class="block text-sm text-black dark:text-white"
        for="form-input-{{ $name }}"
    >{{ $label }}</label>
@endif


@foreach($options as $value => $label)
    <label
        @class([
            $containerClass,
            'cursor-pointer mr-6 py-1 flex gap-2 max-w-lg',
            ($display === \BondarDe\LaravelToolbox\View\Components\Form\Choice::DISPLAY_INLINE ? 'inline-flex' : 'flex')
        ])
    >
        <div>
            <input
                {{ $attributes->merge([
                    'type' => $type,
                    'name' => $name . ($isList ? '[]' : ''),
                    'value' => $value,
                    'id' => 'form-input-' . $name,
                ]) }}
                {!! $checked($value) !!}
            >
        </div>
        {{ $label }}
    </label>
@endforeach
