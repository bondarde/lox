<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System;

use BondarDe\Lox\LoxServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Console\EventListCommand;
use Illuminate\Support\Facades\Artisan;

class AdminEventsController extends EventListCommand
{
    public function __invoke(): View
    {
        self::loadSchedule();
        $laravel = app();
        $this->setLaravel($laravel);
        $events = $this->getListenersOnDispatcher();

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.events', compact(
            'events',
        ));
    }

    private static function loadSchedule(): void
    {
        Artisan::call(AboutCommand::class);
    }
}
