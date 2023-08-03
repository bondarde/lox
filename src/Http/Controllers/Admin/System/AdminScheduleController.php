<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\ScheduleEvent;
use BondarDe\Lox\LoxServiceProvider;
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

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.schedule', compact(
            'scheduleEvents',
        ));
    }

    private static function loadSchedule(): void
    {
        Artisan::call(AboutCommand::class);
    }
}
