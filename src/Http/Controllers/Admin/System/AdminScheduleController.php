<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System;

use BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Data\ScheduleEvent;
use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Artisan;

class AdminScheduleController
{
    public function __invoke(): View
    {
        self::loadSchedule();

        $scheduleEvents = collect(app(Schedule::class)->events())
            ->map(fn($event) => ScheduleEvent::from($event))
            ->sortBy('nextRun');

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.schedule', compact(
            'scheduleEvents',
        ));
    }

    private static function loadSchedule(): void
    {
        Artisan::call(AboutCommand::class);
    }
}
