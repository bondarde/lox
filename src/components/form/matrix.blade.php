<div class="overflow-x-auto">
    <table class="w-full md:w-auto">
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
                        <div class="max-w-xs">
                            @if($showErrors)
                                <x-form.input-error
                                    for="{{ $propKey }}"
                                />
                            @endif

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
                            <span class="md:hidden">
                                {{ $valLabel }}
                                @if($loop->first && $minValue)
                                    ({{ $minValue }})
                                @endif
                                @if($loop->last && $maxValue)
                                    ({{ $maxValue }})
                                @endif
                            </span>
                        </label>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        @if($minValue || $maxValue)
            <tfoot class="hidden md:table-footer-group">
            <tr>
                @if($showPropLabel)
                    <td></td>
                @endif
                <td
                    class="text-sm overflow-visible pl-2"
                    style="max-width: 1rem"
                >{{ $minValue }}</td>
                <td colspan="{{ count($options) - 2 }}"></td>
                <td
                    class="text-sm overflow-visible pl-2"
                    style="max-width: 1rem"
                >{{ $maxValue }}</td>
            </tr>
            </tfoot>
        @endif
    </table>
</div>
