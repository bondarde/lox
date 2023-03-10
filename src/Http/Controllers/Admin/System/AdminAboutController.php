<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Artisan;

class AdminAboutController
{
    public function __invoke(): View
    {
        Artisan::call(AboutCommand::class, [
            '--json' => 1,
        ]);
        $output = Artisan::output();
        $systemStatus = json_decode($output);

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.about', compact(
            'systemStatus',
        ));
    }
}
