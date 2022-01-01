<?php

namespace BondarDe\LaravelToolbox\Http\Controllers;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Illuminate\Support\Facades\View;

abstract class BaseController
{
    protected static function viewWithFallback(string $viewName, array $data = [], array $mergeData = []): \Illuminate\Contracts\View\View
    {
        $views = [
            $viewName,
            LaravelToolboxServiceProvider::NAMESPACE . '::' . $viewName,
        ];

        return View::first($views, $data, $mergeData);
    }
}
