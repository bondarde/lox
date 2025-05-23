@switch(gettype($label))
    @case('string')
        <option
            value="{{ $value }}"
            {{ $selected($value) }}
        >
            {{ $label }}
        </option>
        @break
    @case('array')
        <optgroup label="{{ $value }}">
            @foreach($label as $key => $val)
                @include(\BondarDe\Lox\LoxServiceProvider::$namespace.'::components.form._select-option', [
                    'value' => $key,
                    'label' => $val,
                ])
            @endforeach
        </optgroup>
        @break
@endswitch
