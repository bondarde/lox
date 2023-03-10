<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Illuminate\Routing\Router;

class AdminRoutesController
{
    public function __invoke(
        Router $router,
    )
    {
        $routes = collect($router->getRoutes()->getRoutes())
            ->sortBy('uri');

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.routes', compact(
            'routes',
        ));
    }
}
