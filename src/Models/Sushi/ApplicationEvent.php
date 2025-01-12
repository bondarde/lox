<?php

namespace BondarDe\Lox\Models\Sushi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Console\EventListCommand;
use Illuminate\Support\Facades\Artisan;
use Sushi\Sushi;

class ApplicationEvent extends Model
{
    use Sushi;

    protected $casts = [
        'listeners' => 'array',
    ];

    public function getRows()
    {
        self::loadSchedule();

        $eventsListProxy = new class extends EventListCommand
        {
            public function events()
            {
                return $this->getListenersOnDispatcher();
            }
        };

        $laravel = app();
        $eventsListProxy->setLaravel($laravel);

        return collect($eventsListProxy->events())
            ->map(fn (array $listeners, string $event) => [
                'event' => $event,
                'listeners' => json_encode($listeners),
            ])
            ->values()
            ->toArray();
    }

    private static function loadSchedule(): void
    {
        Artisan::call(AboutCommand::class);
    }
}
