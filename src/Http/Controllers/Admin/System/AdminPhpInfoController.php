<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\System;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;

class AdminPhpInfoController
{
    public function __invoke()
    {
        ob_start();
        phpinfo();
        $phpInfoContents = ob_get_clean();

        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.system.php-info', compact(
            'phpInfoContents',
        ));
    }
}
