@if($showErrors)
    <x-lox::form.input-error
        for="{{ $name }}"
        class="mb-1"
    />
@endif

<label>
    @if($label)
        <div
            class="block text-sm text-black dark:text-white"
        >{{ $label }}</div>
    @endif

    <select
        {{ $attributes->merge([
            'name' => $name,
            'class'=> 'border p-2 rounded-md shadow-sm border outline-none ring ring-transparent w-full dark:border-gray-700 dark:bg-gray-800 ' . $cssClasses,
            'id' => 'form-input-' . $name,
        ]) }}
    >

        <option disabled value="" {{ $old === null ? 'selected' : '' }}>– bitte auswählen –</option>

        @foreach($options as $value => $label)
            @include(\BondarDe\Lox\LoxServiceProvider::$namespace.'::form._select-option')
        @endforeach
    </select>
</label>
