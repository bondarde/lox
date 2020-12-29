<x-content
    class="md:flex md:border-l-4 text-gray-800 focus-within:text-black focus-within:border-gray-700 focus-within:shadow-xl"
>
    <div class="mb-4 md:w-1/4">
        <label
            class="block font-semibold"
            {!! $labelProps !!}>
            {{ $label }}
        </label>

        @if($info)
            <div class="text-sm text-gray-500 hover:text-black">
                {{ $info }}
            </div>
        @endif
    </div>
    <div class="md:w-3/4">
        @if($showErrors)
            <x-form.input-error
                for="{{ $for }}"
                class="mb-2"
            />
        @endif

        {{ $slot }}

        @if($description)
            <div class="text-sm max-w-lg mt-2 text-gray-500 hover:text-black">
                {{ $description }}
            </div>
        @endif
    </div>
</x-content>
