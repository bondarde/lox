<?php

namespace BondarDe\Lox\View\Components\Cms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class AdminNavigation extends Component
{
    public function render(): ?View
    {
        if (!Route::is('admin.cms-*.*')) {
            return null;
        }

        return view('lox::cms.admin-navigation');
    }
}
