<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Cms;

class AdminCmsRedirectsController
{
    public function index()
    {
        return view('lox::admin.cms-pages.redirects.index');
    }
}
