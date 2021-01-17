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
    @if($prefix)
        <span class="flex items-center text-sm px-2 text-gray-600 bg-gray-50 border-r">{{ $prefix }}</span>
    @endif
    <input
        {{ $attributes->merge([
            'type' => $type ,
            'name' => $name,
            'class' => 'flex-grow border-none outline-none p-2 dark:bg-gray-800 ' . $inputClass,
            'id' => 'form-input-' . $name,
            'value' => $value,
            'placeholder' => $placeholder,
            'autocomplete' => 'off',
        ]) }}
        {!! $props !!}/>
    @if($suffix)
        <span class="flex items-center text-sm px-2 text-gray-600 bg-gray-50 border-l">{{ $suffix }}</span>
    @endif
</label>
