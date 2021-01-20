<div class="overflow-x-auto">
    <table class="w-full md:w-auto md:border-b">
        <thead class="hidden md:table-header-group">
        <tr>
            @if($showPropLabel)
                <td></td>
            @endif
            @foreach($options as $valKey => $valLabel)
                <td class="text-center" title="{{ $valKey }}">
                    <div class="max-w-xs px-1" style="min-width: 40px">
                        {{ $valLabel }}
                    </div>
                </td>
            @endforeach
        </tr>
        </thead>
        <tbody class="block md:table-row-group">
        @foreach($props as $propKey => $propLabel)
            <tr class="block md:table-row border md:border-t mb-8 rounded-lg overflow-hidden shadow md:shadow-none">
                @if($showPropLabel)
                    <td class="block md:table-cell px-2 py-1 font-bold border-b md:border-b-none md:border-r">
                        @error($propKey)
                        <div class="font-weight-bold text-danger">{{ $message }}</div>
                        @enderror

                        <div class="max-w-xs">
                            {{ $propLabel }}
                        </div>
                    </td>
                @endif

                @foreach($options as $valKey => $valLabel)
                    <td class="block md:table-cell py-1 md:text-center md:border-r">
                        <label
                            class="cursor-pointer block px-2 md:py-1"
                            title="{{ $valLabel }}"
                        >
                            <input
                                type="radio"
                                name="{{ $propKey }}"
                                value="{{ $valKey }}"
                                {{ $checked($propKey, $valKey) }}>
                            <span class="md:hidden">{{ $valLabel }}</span>
                        </label>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
