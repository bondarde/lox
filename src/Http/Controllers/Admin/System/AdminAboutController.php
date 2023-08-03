<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System;

use BondarDe\Lox\LoxServiceProvider;
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

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.about', compact(
            'systemStatus',
        ));
    }
}
