<?php

namespace BondarDe\Lox\Http\Controllers\Admin\System;

use BondarDe\Lox\LoxServiceProvider;

class AdminPhpInfoController
{
    public function __invoke()
    {
        ob_start();
        phpinfo();
        $phpInfoContents = ob_get_clean();

        return view(LoxServiceProvider::NAMESPACE . '::admin.system.php-info', compact(
            'phpInfoContents',
        ));
    }
}
