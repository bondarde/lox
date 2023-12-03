<?php

namespace BondarDe\Lox\Http\Controllers\Admin\Cms\Assistant;

class AdminCmsAssistantIndexController
{
    public function __invoke()
    {
        return view('lox::admin.cms-pages.assistant.index');
    }
}
