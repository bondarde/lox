@if($label)
    <label
        class="block text-black text-sm"
        for="form-input-{{ $name }}"
    >{{ $label }}</label>
@endif

<x-form.input-error
    for="{{ $name }}"
    class="mb-1"
/>

<select class="border p-2 rounded-md shadow-sm border outline-none ring-4 ring-transparent w-full {{ $cssClasses }}"
        name="{{ $name }}"
        id="form-input-{{ $name }}">

    <option disabled value="" {{ $old === null ? 'selected' : '' }}>– bitte auswählen –</option>

    @foreach($options as $value => $label)
        <option
            value="{{ $value }}"
            {{ $selected($value) }}
        >
            {{ $label }}
        </option>
    @endforeach
</select>
