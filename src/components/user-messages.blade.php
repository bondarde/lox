@if(session()->has('error-message'))
    <div class="px-4 py-2 rounded-lg border border-red-200 bg-red-100 text-red-700 shadow-lg">
        {{ session()->get('error-message') }}
    </div>
@endif

@if(session()->has('success-message'))
    <div class="px-4 py-2 rounded-lg border border-green-200 bg-green-100 text-green-700 shadow-lg">
        {{ session()->get('success-message') }}
    </div>
@endif
