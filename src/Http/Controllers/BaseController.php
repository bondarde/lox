<?php

namespace BondarDe\Lox\Http\Controllers;

use BondarDe\Lox\LoxServiceProvider;
use Illuminate\Support\Facades\View;

abstract class BaseController
{
    protected static function viewWithFallback(string $viewName, array $data = [], array $mergeData = []): \Illuminate\Contracts\View\View
    {
        $views = [
            $viewName,
            LoxServiceProvider::NAMESPACE . '::' . $viewName,
        ];

        return View::first($views, $data, $mergeData);
    }
}
