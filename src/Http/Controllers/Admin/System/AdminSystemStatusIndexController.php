<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System;

use BondarDe\Lox\Http\Controllers\Admin\System\Data\SystemCategory;
use BondarDe\Lox\LoxServiceProvider;
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
                'Models',
                'Application’s Eloquent models',
                route('admin.system.models.index'),
            ),
            new SystemCategory(
                'Database',
                'Database details: tables sizes, indexes, foreign keys',
                route('admin.system.database.index'),
            ),
            new SystemCategory(
                'Search Status',
                'Scout TNT Search status',
                route('admin.system.search-status'),
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
            new SystemCategory(
                'PHP Info',
                'Information about PHP’s configuration',
                route('admin.system.php-info'),
            ),
        ];

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.index', compact(
            'categories',
        ));
    }
}
