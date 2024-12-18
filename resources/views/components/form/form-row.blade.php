<x-lox::content
    class="md:flex gap-8 md:border-l-4 text-gray-800 dark:text-gray-100 focus-within:text-black dark:focus-within:text-white focus-within:border-gray-700 dark:border-gray-800 focus-within:dark:border-gray-700 focus-within:shadow-xl"
>
    <div class="mb-4 md:w-1/4">
        <label
            class="block font-semibold"
            {!! $labelProps !!}>
            {{ $label }}
        </label>

        @if($info)
            <div class="text-sm text-gray-500 hover:text-black dark:hover:text-white">
                {{ $info }}
            </div>
        @endif
    </div>
    <div class="md:w-3/4">
        @if($showErrors)
            <x-lox::form.input-error
                for="{{ $for }}"
                class="mb-2"
            />
        @endif

        {{ $slot }}

        @if($description)
            <div class="text-sm max-w-lg mt-1 text-gray-500 hover:text-black dark:hover:text-white">
                {{ $description }}
            </div>
        @endif
    </div>
</x-lox::content>
