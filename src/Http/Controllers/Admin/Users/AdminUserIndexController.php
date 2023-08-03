<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Users;

use BondarDe\Lox\LoxServiceProvider;

class AdminUserIndexController
{
    public function __invoke()
    {
        return view(LoxServiceProvider::NAMESPACE . '::admin.users.index');
    }
}
