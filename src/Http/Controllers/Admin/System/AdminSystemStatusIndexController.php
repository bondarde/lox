<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System;

use BondarDe\LaravelToolbox\Http\Controllers\Admin\System\Data\SystemCategory;
use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Illuminate\Contracts\View\View;

class AdminSystemStatusIndexController
{
    public function __invoke(): View
    {
        $categories = [
            new SystemCategory(
                'About',
                'System summary',
                route('admin.system.about'),
            ),
            new SystemCategory(
                'Database',
                'Database details: tables sizes, indexes, foreign keys',
                route('admin.system.database.index'),
            ),
            new SystemCategory(
                'Schedule',
                'Scheduled tasks with previous/last runs & details',
                route('admin.system.schedule'),
            ),
            new SystemCategory(
                'Events',
                'Application events and their listeners',
                route('admin.system.events'),
            ),
            new SystemCategory(
                'Routes',
                'All routes',
                route('admin.system.routes'),
            ),
            new SystemCategory(
                'Cache',
                'Values cached with filesystem driver',
                route('admin.system.cache'),
            ),
        ];

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.index', compact(
            'categories',
        ));
    }
}
