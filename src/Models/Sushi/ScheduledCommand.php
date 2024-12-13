<?php

namespace BondarDe\Lox\Models\Sushi;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\ScheduleEvent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Artisan;
use Sushi\Sushi;

class ScheduledCommand extends Model
{
    use Sushi;

    public function getRows()
    {
        self::loadSchedule();

        return collect(app(Schedule::class)->events())
            ->map(fn ($event) => ScheduleEvent::from($event))
            ->map(fn (ScheduleEvent $event) => (array) $event)
            ->sortBy('nextRun')
            ->toArray();
    }

    private static function loadSchedule(): void
    {
        Artisan::call(AboutCommand::class);
    }
}
