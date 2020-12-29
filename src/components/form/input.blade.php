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
    @if($prefix)
        <span class="flex items-center text-sm px-2 text-gray-600 bg-gray-50 border-r">{{ $prefix }}</span>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        class="flex-grow border-none outline-none p-2 {{ $inputClass }}"
        id="form-input-{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ $value }}"
        autocomplete="off"
        {!! $props !!}/>
    @if($suffix)
        <span class="flex items-center text-sm px-2 text-gray-600 bg-gray-50 border-l">{{ $suffix }}</span>
    @endif
</label>
