@if($showErrors)
    <x-form.input-error
        for="{{ $name }}"
        class="mb-2"
    />
@endif


@if($label)
    <label
        class="block text-black text-sm"
        for="form-input-{{ $name }}"
    >{{ $label }}</label>
@endif


@foreach($options as $value => $label)
    <label
        class="{{ ($display === \BondarDe\LaravelToolbox\View\Components\Form\Choice::DISPLAY_INLINE ? 'inline-block' : 'block') }} cursor-pointer mr-4 -ml-4 pl-4">
        <input
            class="mr-1"
            type="{{ $type }}"
            name="{{ $name }}{{ $isList ? '[]' : '' }}"
            value="{{ $value }}"
            {!! $checked($value) !!}
        >
        {{ $label }}
    </label>
@endforeach
