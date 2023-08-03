<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System;

use BondarDe\Lox\LoxServiceProvider;
use Illuminate\Routing\Router;

class AdminRoutesController
{
    public function __invoke(
        Router $router,
    )
    {
        $routes = collect($router->getRoutes()->getRoutes())
            ->sortBy('uri');

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.routes', compact(
            'routes',
        ));
    }
}
