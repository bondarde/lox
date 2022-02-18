<?php

namespace BondarDe\LaravelToolbox\Http\Controllers\Admin\Users;

use BondarDe\LaravelToolbox\LaravelToolboxServiceProvider;

class AdminUserIndexController
{
    public function __invoke()
    {
        return view(LaravelToolboxServiceProvider::NAMESPACE . '::admin.users.index');
    }
}
