<x-admin-page
    title="System Status"
    h1="System Status"
>

    <div class="flex flex-col gap-8 max-w-lg">
        @foreach($categories as $category)
            <a
                class="group bg-white dark:bg-gray-800 p-4 shadow rounded-lg inline-block"
                href="{{ $category->uri }}"
            >
                <h2 class="group-hover:underline  mb-1">
                    {{ $category->label }}
                </h2>
                <div class="opacity-50 group-hover:opacity-100">
                    {{ $category->description }}
                </div>
            </a>
        @endforeach
    </div>

</x-admin-page>
