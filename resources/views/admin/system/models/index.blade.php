<x-admin-page
    title="Models"
    h1="Models"
>

    <ul>
        @foreach($models as $model)
            <li>
                <a
                    class="hover:underline"
                    href="{{ route('admin.system.models.list', $model->fullyQualifiedClassName) }}"
                >
                    {!! $model->htmlLabel() !!}
                </a>
            </li>
        @endforeach
    </ul>

</x-admin-page>
