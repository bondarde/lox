@if($showErrors)
    <x-form.input-error
        for="{{ $name }}"
        class="mb-1"
    />
@endif

<label>
    @if($label)
        <div
            class="block text-black text-sm"
        >{{ $label }}</div>
    @endif

    <select
        {{ $attributes->merge([
            'name' => $name,
            'class'=> 'border p-2 rounded-md shadow-sm border outline-none ring-4 ring-transparent w-full ' . $cssClasses,
            'id' => 'form-input-' . $name,
        ]) }}
    >

        <option disabled value="" {{ $old === null ? 'selected' : '' }}>– bitte auswählen –</option>

        @foreach($options as $value => $label)
            @include(\BondarDe\LaravelToolbox\LaravelToolboxServiceProvider::NAMESPACE.'::form._select-option')
        @endforeach
    </select>
</label>
