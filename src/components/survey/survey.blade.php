<x-validation-errors
    class="mb-4"
/>

<form method="post" action="{{ $formActionUri }}" {{ $attributes }}>
    @csrf

    <div class="hidden md:flex shadow-sm rounded-lg select-none">
        @foreach($steps as $step)
            @if($showStepLink($loop->index))
                <a
                    class="{{ $toStepClasses($loop) }}"
                    href="{{ $step->getUri($model, $loop->iteration) }}"
                    title="{{ $step->getLabelHtml() }}"
                >
                    <strong
                        class="text-sm px-2 py-1 text-center bg-gray-100 bg-opacity-50 rounded-full overflow-hidden"
                    >{{ $loop->iteration }}</strong>
                    {!! $step->getLabelHtml() !!}
                </a>
            @else
                <span
                    class="{{ $toStepClasses($loop) }}"
                    title="{{ $step->getLabelHtml() }}"
                >
                    <strong
                        class="text-sm px-2 py-1 text-center bg-gray-100 bg-opacity-50 rounded-full overflow-hidden"
                    >{{ $loop->iteration }}</strong>
                    {!! $step->getLabelHtml() !!}
                </span>
            @endif
        @endforeach
    </div>

    <input
        type="hidden"
        name="{{ \BondarDe\LaravelToolbox\Surveys\SurveyStep::CURRENT_STEP_FORM_PARAMETER }}"
        value="{{ $currentStepIndex + 1 }}"
    >

    <div class="mb-8 md:mt-8">
        <h2 class="mb-2">{!! $steps[$currentStepIndex]->getLabelHtml() !!}</h2>
        @include($stepFormTemplate)
    </div>

    <x-form.form-actions>
        <x-button-green
            class="w-full max-w-sm justify-center"
        >
            {{ $nextStepIndex > -1 ? 'Weiter' : 'Speichern' }}
            <span class="ml-4">➜</span>
        </x-button-green>
        @if($nextStepIndex > -1)
            <div class="text-sm opacity-75 mt-1">
                Zu „{!! $steps[$nextStepIndex]->getLabelHtml() !!}“
            </div>
        @endif


        @if($previousStepIndex > -1)
            <x-slot name="back">
                <x-button-light
                    tag="{{ \BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK }}"
                    href="{{ $steps[$previousStepIndex]->getUri($model, $previousStepIndex + 1) }}"
                >
                    ←
                    Zurück
                </x-button-light>
                <div class="text-sm opacity-75 mt-1">
                    Zu „{!! $steps[$previousStepIndex]->getLabelHtml() !!}“
                </div>
            </x-slot>
        @endif

        @if($cancelUri)
            <x-slot name="cancel">
                <x-button-danger
                    class="opacity-75"
                    tag="{{ \BondarDe\LaravelToolbox\View\Components\Buttons\Button::TAG_LINK }}"
                    href="{{ $cancelUri }}"
                >
                    Abbrechen
                </x-button-danger>
                @if($cancelInfo)
                    <div class="text-sm opacity-75 mt-1">
                        {{ $cancelInfo }}
                    </div>
                @endif
            </x-slot>
        @endif

    </x-form.form-actions>

</form>
