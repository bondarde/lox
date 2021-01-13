@if($showErrors)
    <x-form.input-error
        for="{{ $name }}"
        class="mb-1"
    />
@endif

@if($label)
    <label
        class="block text-black text-sm"
        for="form-input-{{ $name }}"
    >{{ $label }}</label>
@endif

<label
    class="flex overflow-hidden rounded-md shadow-sm border ring-4 ring-transparent {{ $containerClass }}"
>
    <textarea
        {{ $attributes->merge([
            'name' => $name,
            'class' => 'flex-grow border-none outline-none p-2 ' . $inputClass,
            'id' => 'form-input-' . $name,
            'autocomplete' => 'off',
            'rows' => '6',
        ]) }}
    >{!! $value !!}</textarea>
</label>
