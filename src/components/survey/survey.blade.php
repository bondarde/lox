<x-validation-errors
    class="mb-4"
/>

<form method="post" action="{{ $formActionUri }}" {{ $attributes }}>
    @csrf

    <div class="md:flex shadow rounded-lg select-none">
        @foreach($steps as $step)
            <div
                class="p-4 border dark:border-gray-700 flex-grow {{ $currentStepIndex === $loop->index ? 'link--active border-indigo-900' : 'bg-white dark:bg-gray-800 hidden md:block' }} {{ $loop->index > 0 ? 'border-l-0' : '' }} {{ $loop->first ? 'rounded-l-lg' : '' }} {{ $loop->last ? 'rounded-r-lg' : '' }}"
            >
                <strong>{{ $loop->iteration }}:</strong>
                {!! $step->getLabelHtml() !!}
            </div>
        @endforeach
    </div>

    <input type="hidden"
           name="{{ \BondarDe\LaravelToolbox\Surveys\SurveyStep::CURRENT_STEP_FORM_PARAMETER }}"
           value="{{ $currentStepIndex + 1 }}">

    <div class="my-8">
        <h2 class="mb-8">{!! $steps[$currentStepIndex]->getLabelHtml() !!}</h2>
        @include($stepFormTemplate)
    </div>

    <x-form.form-actions>
        @if($previousStepIndex > -1)
        @endif
        <x-button-green>
            {{ $nextStepIndex > -1 ? 'Weiter' : 'Speichern' }}
        </x-button-green>
    </x-form.form-actions>

</form>
