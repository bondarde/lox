<x-admin-page
    title="Schedule"
    h1="Schedule"
>

    <x-content class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>Command</th>
                <th>Next Run</th>
                <th>Previous Run</th>
                <th>Schedule</th>
                <th>Output</th>
            </tr>
            </thead>
            @foreach($scheduleEvents as $event)
                <tr class="border-t">
                    <td>
                        {{ $event->command }}
                        <div class="text-sm opacity-50">
                            {{ $event->description }}
                        </div>
                        <div class="opacity-50 text-sm font-semibold">{{ $event->type }}</div>
                    </td>
                    <td class="whitespace-nowrap">
                        {{ $event->nextRun->diffForHumans() }}
                        <div class="text-sm opacity-50">
                            {{ $event->nextRun }}
                        </div>
                    </td>
                    <td class="whitespace-nowrap">
                        {{ $event->previousRun->diffForHumans() }}
                        <div class="text-sm opacity-50">
                            {{ $event->previousRun }}
                        </div>
                    </td>
                    <td class="whitespace-nowrap">
                        {{ $event->expression }}
                        <div class="text-sm opacity-50">
                            {{ $event->timezone }}
                        </div>
                    </td>
                    <td>
                        {{ $event->output }}
                    </td>
                </tr>
            @endforeach
        </table>
    </x-content>

    <p>
        PHP Binary: {{ \Illuminate\Console\Application::phpBinary() }}
        <br>
        Artisan Binary: {{ \Illuminate\Console\Application::artisanBinary() }}
    </p>


</x-admin-page>
