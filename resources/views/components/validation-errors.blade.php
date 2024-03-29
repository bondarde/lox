@if ($errors->any())
    <div {{ $attributes }}>
        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 pb-6 rounded-lg shadow-lg">
            <p class="font-medium mb-2">
                {{ trans_choice('Please pay attention to following hint to proceed:|Please pay attention to following hints to proceed:', $errors->count()) }}
            </p>

            <ul class="pl-4 list-disc">
                @foreach ($errors->all() as $error)
                    @if($loop->iteration > $limit && $errors->count() > $limit + 1)
                        @break
                    @endif

                    <li class="mt-1">{{ $error }}</li>
                @endforeach
            </ul>

            @if($errors->count() > $limit + 1)
                <p class="mt-2">
                    … und {{ $errors->count() - $limit }} weitere.
                </p>
            @endif
        </div>
    </div>
@endif
