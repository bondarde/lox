@if($showErrors)
    <x-form.input-error
        for="{{ $name }}"
        class="mb-1"
    />
@endif

@if($label)
    <label
        class="block text-sm text-black dark:text-white"
        for="form-input-{{ $name }}"
    >{{ $label }}</label>
@endif

<label
    class="flex overflow-hidden rounded-md shadow-sm border ring ring-transparent dark:border-gray-700 {{ $containerClass }}"
>
    <textarea
        {{ $attributes->merge([
            'name' => $name,
            'class' => 'grow border-none outline-none p-2 dark:bg-gray-800 ' . $inputClass,
            'id' => 'form-input-' . $name,
            'autocomplete' => 'off',
            'rows' => '6',
        ]) }}
    >{!! $value !!}</textarea>
</label>
