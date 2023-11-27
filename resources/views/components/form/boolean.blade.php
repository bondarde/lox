<label class="flex gap-2 cursor-pointer">
    <input
        {{ $attributes->class('form-boolean') }}
        type="checkbox"
        name="{{ $name }}"
        {!! $checked !!}
    >
    <span class="align-middle select-none">{{ $slot ?? $label }}</span>
</label>
